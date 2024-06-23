<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Home\Models;

use App\Modules\Product\Models\Product;
use App\Modules\Service\Models\Service;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $table = 'home_settings';
    protected $fillable = array(
        'title', 'title_color', 'title_position', 'image', 'background_color', 'order', 'quantity', 'status',
        'item_type', 'blog_id', 'content', 'home_setting_type', 'name', 'item_title_position', 'css', 'product_type',
        'parameters'
    );
    const PRODUCT_TYPE = 1;
    const BLOG_TYPE = 2;
    const INTRODUCTION_TYPE = 3;
    const MAKE_AN_APPOINTMENT_TYPE = 4;
    const FEEL_TYPE = 5;
    const BANNER_1PHOTO_TYPE = 6;
    const BANNER_3PHOTO_TYPE = 7;
    const SQUARE_CORNER_SERVICE_TYPE = 8;
    const ROUND_CORNER_SERVICE_TYPE = 9;
    const NEW_PRODUCT_TYPE = 10;
    const IMAGE_TYPE = 11;
    const PARTNER_TYPE = 12;
    const DEFAULT_BLOG_TYPE = 13;
    const LEFT_BLOG_TYPE = 14;
    const RIGHT_BLOG_TYPE = 15;
    const CONTACT_TYPE = 16;
    const NEWS_TYPE = 17;
    const BRAND_TYPE = 18;
    const COMMITMENT_TYPE = 19;
    const SELLING_PRODUCT_TYPE = 20;
    const OTHER_SERVICE_TYPE = 21;
    const QUOTES_AND_PROMOTIONS = 22;
    const IMAGE_TYPE_RECTANGLE = 23;
    const BORDER_SERVICE_TYPE = 24;
    const FULL_SERVICE_TYPE = 25;
    const SLIDE_4_SERVICE_TYPE = 26;
    const VIDEO_DISPLAY_TYPE = 27;

    const FOLDER_DISPLAY_TYPE = 1;
    const MENU_DISPLAY_TYPE = 2;
    const BANNER_DISPLAY_TYPE = 3;
    const SERVICE_DISPLAY_TYPE = 4;
    const IMAGE_DISPLAY_TYPE = 5;
    const BLOG_DISPLAY_TYPE = 6;

    //
    const SERVICE_TWO = 1;
    const SERVICE_THREE = 2;
    const SERVICE_THREE_SPECIAL = 3;
    const SERVICE_FOUR = 4;
    const SERVICE_FOUR_SPECIAL = 5;
    const SERVICE_FIVE = 6;
    const SERVICE_SIX = 7;
    const BORDER_SERVICE_TWO = 8;
    const BORDER_SERVICE_THREE = 9;
    const BORDER_SERVICE_FOUR = 10;
    const BORDER_SERVICE_FIVE = 11;
    const BORDER_SERVICE_SIX = 12;

    const HOME_PAGE = 999999999;

    const PRODUCT_TYPE_1 = 1;
    const PRODUCT_TYPE_2 = 2;
    const PRODUCT_TYPE_3 = 3;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'home_products', 'home_setting_id', 'product_id')
            ->withPivot('order')
            ->orderBy('home_products.order')
            ->where('product.status', 1)
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'home_blogs', 'home_setting_id', 'blog_id')
            ->withPivot('order')
            ->orderBy('home_blogs.order')
            ->where('blog.status', 1)
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'home_services', 'home_setting_id', 'service_id')
            ->withPivot('order')
            ->orderBy('home_services.order')
            ->withTimestamps();
    }
}


