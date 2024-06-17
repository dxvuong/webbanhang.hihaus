<?php
namespace App\Modules\App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model{
    protected $table = 'app_menus';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'icon', 'menu_type', 'order', 'parent', 'status'
    );

    const EXAM_TYPE = 'de-thi';
    const BLOG_TYPE = 'blog';
    const THEORY_TYPE = 'link';

    const MenuConstantArray = [
        self::EXAM_TYPE => "Đề thi",
        self::BLOG_TYPE => "Blog: tin ảnh, video, text ",
        self::THEORY_TYPE => "Lý thuyết"
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent');
    }

    public function theories()
    {
        return $this->belongsToMany(Theory::class, 'app_menu_show', 'menu_id', 'menu_show_type_id')
            ->withPivot('menu_show_type')
            ->wherePivot('menu_show_type', MenuShow::THEORY_MENU_SHOW_TYPE)
            ->withTimestamps();
    }

    static function getAllSubMenuIds($menuId) {
        $subMenuIds = Menu::where('parent', $menuId)->pluck('id')->toArray();

        foreach ($subMenuIds as $subMenuId) {
            $subMenuIds = array_merge($subMenuIds, self::getAllSubMenuIds($subMenuId));
        }
        $subMenuIds[] = $menuId;
        return $subMenuIds;
    }

    public function generateMenuBreadcrumb() {
        $menuParent = \App\Modules\Home\Models\Menu::where('parent', '=', NULL)
            ->where('item_type', '=', \App\Modules\Home\Models\Menu::LINK_TYPE)
            ->where('link', 'app-api')
            ->where('status', '=', 1)
            ->first();
        $breadcrumb = '<li class="breadcrumb-item"><a href="#">' . $menuParent->name . '</a></li>';

        if (!empty($this->parent)) {
            $parent = self::find($this->parent);
            if (!empty($parent)) {
                if (!empty($parent->parent)) {
                    $grandParent = self::find($parent->parent);
                    if (!empty($grandParent)) {
                        $breadcrumb .= '<li class="breadcrumb-item"><a href="/' . $menuParent->slug . '/' . $grandParent->slug . '">' . $grandParent->name . '</a></li>';
                    }
                }
                $breadcrumb .= '<li class="breadcrumb-item"><a href="/' . $menuParent->slug . '/' . $parent->slug . '">' . $parent->name . '</a></li>';
            }
        }

        $breadcrumb .= '<li class="breadcrumb-item"><a href="/' . $menuParent->slug . '/' . $this->slug . '">' . $this->name . '</a></li>';

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
}

