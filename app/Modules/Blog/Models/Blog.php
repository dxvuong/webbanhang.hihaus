<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Blog\Models;

use App\Modules\Home\Models\Menu;
use App\Modules\Home\Models\SeoMeta;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model{
    protected $table = 'blog';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'image', 'description', 'content', 'category', 'order', 'status', 'slug', 'author', 'menu', 'link'
    );

    public function generateURL($menu = null) {
        if (!empty($this->link)) {
            return $this->link;
        }
        if (!empty($menu)) {
            $url = $menu->link . '/';
        }else {
            $url = '/blog/chi-tiet/';
            if (!empty($this->menu)) {
                $menu = Menu::find($this->menu);
                if (!empty($menu)) {
                    $url = $menu->getParam($url) . $this->slug;
                    return url($url);
                }
            }
        }
        $url .= $this->slug;
        return url($url);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_blog', 'blog_id', 'menu_id');
    }

    public function seoMeta()
    {
        return $this->hasOne(SeoMeta::class, 'item_id')->where('item_type', SeoMeta::BLOG_TYPE);
    }

    const NAVBAR_TYPE_PRODUCT = 1;
    const NAVBAR_TYPE_BLOG = 2;
}
