<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model{
    protected $table = 'page';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'content', 'slug', 'order', 'status', 'author', 'image', 'title', 'description', 'page_type', 'page_type_col', 'banner_images'
    );

    const PAGE_TYPE_COL = 1;
    const PAGE_TYPE_PRODUCT = 2;
    const PAGE_TYPE_BLOG = 3;
    const PAGE_TYPE_BANNER = 4;
}


