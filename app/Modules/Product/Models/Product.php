<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Product\Models;

use App\Modules\Home\Models\Brand;
use App\Modules\Home\Models\Menu;
use App\Modules\Home\Models\SeoMeta;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'image', 'images', 'price_regular', 'price_sale', 'code', 'description', 'content', 'category', 'order', 'link', 'status', 'author', 'menu', 'policy', 'promotion', 'parameter', 'year_id', 'brand_id', 'vat', 'model', 'origin', 'warranty', 'size', 'weight', 'unit', 'product_manual', 'selling_order'
    );

    public function generateURL($menu = null) {
        if (!empty($this->link)) {
            return $this->link;
        }
        $url = $this->slug;
        return url($url);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_product', 'product_id', 'menu_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id')->orderBy('created_at', 'desc')->skip(0)->take(6);
    }
    public function seoMeta()
    {
        return $this->hasOne(SeoMeta::class, 'item_id')->where('item_type', SeoMeta::PRODUCT_TYPE);
    }
}
