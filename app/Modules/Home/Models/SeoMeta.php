<?php
namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model{
    protected $table = 'seo_metas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_type', 'item_id', 'meta_title', 'meta_url', 'meta_description', 'meta_robots', 'canonical', 'meta_image'
    ];

    const BLOG_TYPE = 1;
    const PRODUCT_TYPE = 2;

    public function getRobot()
    {
        $inputString = $this->meta_robots;

        if (strpos($inputString, 'nofollow') === false) {
            $inputString = 'follow,' . $inputString;
        }
        if (strpos($inputString, 'nosnippet') !== false) {
            $inputString = substr($inputString, 0, strpos($inputString, 'nosnippet'));
        }else {
            if (strpos($inputString, 'max-snippet') === false && strpos($inputString, 'max-video-preview') === false && strpos($inputString, 'max-image-preview') === false) {
                $inputString .= ',max-snippet:-1,max-video-preview:-1,max-image-preview:large';
            }
        }

        $inputString = rtrim(trim($inputString), ',');

        return $inputString;
    }
    public function getCanonical()
    {
        $inputString = $this->meta_robots;
        if (strpos($inputString, 'noindex') === false) {
            return $this->canonical;
        }
        return '';
    }
}
