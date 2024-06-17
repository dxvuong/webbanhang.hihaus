<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model{
    protected $table = 'blog';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'image', 'description', 'content', 'category', 'order', 'status', 'slug', 'link'
    );

    public function generateURL() {
        if (!empty($this->link)) {
            return $this->link;
        }

        $url = '/blog/chi-tiet/';
        if (!empty($this->menu)) {
            $menu = Menu::find($this->menu);
            if (!empty($menu)) {
                $url = $menu->getParam($url) . $this->slug;
                return url($url);
            }
        }
        $url .= $this->slug;
        return url($url);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_blog', 'blog_id', 'menu_id');
    }
}
