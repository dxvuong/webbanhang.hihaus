<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Footer\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'company_name', 'image', 'logo_header', 'phone', 'email', 'address', 'facebook', 'chat_facebook',
        'link_chat_facebook', 'chat_zalo', 'link_chat_zalo', 'twitter', 'google', 'linkedin', 'youtube',
        'tags', 'zalo', 'bank_account', 'support_information', 'announced', 'image_booking', 'google_analytics',
        'footer_background_color', 'footer_text_color', 'header_background_color', 'header_text_color',
        'icon_background_color', 'icon_color', 'setting_type', 'social_title', 'support_information_title',
        'tag_title', 'tax_code', 'favicon', 'blog_navbar_type'
    );
}