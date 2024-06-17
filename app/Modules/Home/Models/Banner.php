<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model{
    protected $table = 'banner';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'content', 'link_text', 'link', 'image', 'order', 'status', 'type'
    );

    const MAY_TINH = 'may-tinh';
    const DIEN_THOAI = 'dien-thoai';

    const BANNER_SHOW_TYPE_ID = 999999999;
    const MENU_BANNER_SHOW_TYPE = 1;
    const HOME_BANNER_SHOW_TYPE = 2;

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'banner_show', 'banner_id', 'banner_show_type_id')
            ->withPivot('banner_show_type')
            ->wherePivot('banner_show_type', self::MENU_BANNER_SHOW_TYPE)
            ->withTimestamps();
    }

    public function bannerShowHome()
    {
        return $this->hasOne(BannerShow::class, 'banner_id')
            ->where('banner_show_type', self::HOME_BANNER_SHOW_TYPE)
            ->where('banner_show_type_id', self::BANNER_SHOW_TYPE_ID);
    }
}


