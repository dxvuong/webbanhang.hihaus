<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Home\Models;

use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use League\Flysystem\Config;

class Menu extends Model{
    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'item_type', 'link', 'icon', 'parent', 'order', 'status', 'slug', 'position', 'description', 'menu_content', 'icon_fontawesome'
    );

    const PRODUCT_TYPE = 'san-pham';
    const BLOG_TYPE = 'blog';
    const LINK_TYPE = 'link';

    const HORIZONTAL_POSITION = 1;
    const VERTICAL_POSITION = 2;

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent')->where('status', 1)->orderBy('order');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'menu_brand', 'menu_id', 'brand_id');
    }

    public function menuIcon () {
        if (!empty($this->icon)) {
            $icon = '<img class="menu-icon" src="' . config('app.PATH_ADMIN').$this->icon . '" alt="' . $this->name . '">';
        }else {
            $icon = !empty($this->icon_fontawesome) ? $this->icon_fontawesome : '';
        }

        return $icon;
    }

    public function generateMenuBreadcrumb() {
        $breadcrumb = '';

        if (!empty($this->parent)) {
            $parent = self::find($this->parent);
            if (!empty($parent)) {
                if (!empty($parent->parent)) {
                    $grandParent = self::find($parent->parent);
                    if (!empty($grandParent)) {
                        $breadcrumb .= '<li class="breadcrumb-item"><a href="/' . $grandParent->slug . '">' . $grandParent->name . '</a></li>';
                    }
                }
                $breadcrumb .= '<li class="breadcrumb-item"><a href="/' . $parent->slug . '">' . $parent->name . '</a></li>';
            }
        }

        return $breadcrumb;
    }

    public function getParam($defaultUrl)
    {
        $url = '/';

        if (!empty($this->parent)) {
            $parent = self::find($this->parent);
            if (!empty($parent)) {
                if (!empty($parent->parent)) {
                    $grandParent = self::find($parent->parent);
                    if (!empty($grandParent)) {
                        $url .= $grandParent->slug . '/';
                    }else {
                        return $defaultUrl;
                    }
                }
                $url .= $parent->slug . '/';
            }else {
                return $defaultUrl;
            }
        }

        $url .= $this->slug . '/';

        return $url;
    }

    public function itemsByType($itemType, $homeSetting)
    {

        $subquery1 = function ($query) {
            $query->where('parent', $this->id);
        };

        $menuIds = Menu::select('id')
            ->where('id', $this->id)
            ->orWhere(function ($subquery) use ($subquery1) {
                $subquery->where('parent', $this->id);
                $subquery2 = function ($query, $parentId) use ($subquery1) {
                    $query->orWhere(function ($sub) use ($parentId, $subquery1) {
                        $sub->where('parent', $parentId);
                        $subquery1($sub);
                    });
                    $children = Menu::where('parent', $parentId)->pluck('id')->toArray();
                    foreach ($children as $child) {
                        $query->orWhere(function ($sub) use ($child, $subquery1) {
                            $sub->where('parent', $child);
                            $subquery1($sub);
                        });
                    }
                };
                $subquery2($subquery, $this->id);
            })
            ->pluck('id');

        $limit = $homeSetting ? $homeSetting->quantity : 0;

        if ($itemType == HomeSetting::PRODUCT_TYPE) {
            $query = Product::whereIn('id', function ($query) use ($menuIds) {
                $query->select('product_id')
                    ->from('menu_product')
                    ->whereIn('menu_id', $menuIds);
            });
        } else if ($itemType === HomeSetting::BLOG_TYPE) {
            $query = Blog::whereIn('id', function ($query) use ($menuIds) {
                $query->select('blog_id')
                    ->from('menu_blog')
                    ->whereIn('menu_id', $menuIds);
            });
        }
        $query->where('status', 1);

        if ($itemType == HomeSetting::PRODUCT_TYPE) {
            $query->inRandomOrder();
        } else {
            $query->orderByDesc('created_at');
        }
        return $query->limit($limit)->get();
    }

    static function getAllSubMenuIds($menuId, &$visited = array()) {
        if (in_array($menuId, $visited)) {
            return array();
        }
        $visited[] = $menuId;

        $subMenuIds = Menu::where('parent', $menuId)->pluck('id')->toArray();

        foreach ($subMenuIds as $subMenuId) {
            $subMenuIdsRecursive = self::getAllSubMenuIds($subMenuId, $visited);
            $subMenuIds = array_merge($subMenuIds, $subMenuIdsRecursive);
        }

        $subMenuIds[] = $menuId;
        return $subMenuIds;
    }
}
