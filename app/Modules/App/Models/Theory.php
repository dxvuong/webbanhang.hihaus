<?php
namespace App\Modules\App\Models;

use Illuminate\Database\Eloquent\Model;

class Theory extends Model{
    protected $table = 'app_theories';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'image', 'description', 'content', 'order', 'status', 'slug', 'author'
    );

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'app_menu_show', 'menu_show_type_id', 'menu_id')
            ->withPivot('menu_show_type')
            ->wherePivot('menu_show_type', MenuShow::THEORY_MENU_SHOW_TYPE)
            ->withTimestamps();
    }

    public function generateURL($menu = null) {
        $menuParent = \App\Modules\Home\Models\Menu::where('parent', '=', NULL)
            ->where('item_type', '=', \App\Modules\Home\Models\Menu::LINK_TYPE)
            ->where('link', 'app-api')
            ->where('status', '=', 1)
            ->first();
        $defaultUrl = '/theory/chi-tiet/' . $this->slug;

        if (!empty($menu)) {
            $url = "/$menuParent->slug";
            $url .= $menu->getParam($defaultUrl) . $this->slug;
        }else {
            $url = $defaultUrl;
        }

        return url($url);
    }
}

