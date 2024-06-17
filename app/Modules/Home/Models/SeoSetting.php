<?php
namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model{
    protected $table = 'seo_settings';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'website_name', 'slogan', 'site_url', 'email', 'header_script', 'footer_script', 'home_sitemap_priority', 'product_menu_sitemap_priority', 'blog_menu_sitemap_priority', 'product_sitemap_priority', 'blog_sitemap_priority', 'robots_txt'
    );
}
