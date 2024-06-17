<?php

namespace App;

use App\Modules\Footer\Models\Footer;
use App\Modules\Home\Models\SeoSetting;
use App\Modules\Page\Models\Page;
use Intervention\Image\ImageManagerStatic;

class MetaTagManager
{
    protected $setting;
    protected $about;
    protected $seoSetting;
    protected $seoScript;
    protected $metaData = [];

    public function __construct()
    {
        $this->setting = Footer::find(1);
        $this->about = Page::find(1);
        $this->seoSetting = SeoSetting::find(1);
        $this->seoScript = '';

        $this->metaData = [
            'ogp_article' => 'article',
            'robots' => 'index,follow,max-snippet:-1,max-video-preview:-1,max-image-preview:large',
            'canonical' => url($_SERVER['REQUEST_URI']),
            'meta_title' => $this->setting->company_name,
            'meta_description' => $this->about->description,
            'meta_keywords' => $this->about->title,
            'ogp_site_name' => $this->seoSetting->website_name,
            'ogp_title' => $this->setting->company_name,
            'ogp_description' => $this->about->description,
            'ogp_url' => url($_SERVER['REQUEST_URI']),
            'ogp_image' => !empty($this->setting->logo_social) ? config('app.PATH_ADMIN') . $this->setting->logo_social : config('app.PATH_ADMIN') . $this->setting->image,
            'ogp_image_alt' => $this->setting->company_name,
            'article_section' => 'Uncategorized',
            'article_published_time' => time(),
            'article_modified_time' => time(),
        ];
    }

    public function setMetaData(array $metaData)
    {
        foreach ($metaData as $key => $value) {
            if (!empty($value)) {
                $this->metaData[$key] = $value;
            }
        }
    }

    public function getMetaData($key)
    {
        return $this->metaData[$key] ?? null;
    }

    public function getSeo()
    {
        $width = null;
        $height = null;
        $type = null;
//        if (!empty($url = $this->getMetaData('ogp_image'))){
//            $image = ImageManagerStatic::make($url);
//
//            $width = $image->width();
//            $height = $image->height();
//            $type = $image->mime();
//        }

        $publishedTime = $this->getMetaData('article_published_time');
        $modifiedTime = $this->getMetaData('article_modified_time');

        // Chuyển định dạng thời gian theo ISO 8601
        $formattedPublishedTime = date("c", strtotime($publishedTime));
        $formattedModifiedTime = date("c", strtotime($modifiedTime));

        $str = "<!-- start seo -->\n";
        $str .= "\t" . '<meta name="description" content="' . htmlspecialchars($this->getMetaData('meta_description')) . '" />' . "\n";
        $str .= "\t" . '<meta name="robots" content="' . htmlspecialchars($this->getMetaData('robots')) . '" />' . "\n";

        if ($this->getMetaData('canonical')) {
            $str .= "\t" . '<link rel="canonical" href="' . htmlspecialchars($this->getMetaData('canonical')) . '" />' . "\n";
        }

        $str .= "\t" . '<meta property="og:locale" content="vi_VN" />' . "\n";
        $str .= "\t" . '<meta property="og:type" content="' . htmlspecialchars($this->getMetaData('ogp_article')) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:title" content="' . htmlspecialchars($this->getMetaData('ogp_title')) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:description" content="' . htmlspecialchars($this->getMetaData('ogp_description')) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:url" content="' . htmlspecialchars($this->getMetaData('ogp_url')) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:site_name" content="' . htmlspecialchars($this->getMetaData('ogp_site_name')) . '" />' . "\n";
        $str .= "\t" . '<meta property="article:section" content="' . htmlspecialchars($this->getMetaData('article_section')) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:image" content="' . htmlspecialchars($this->getMetaData('ogp_image')) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:image:secure_url" content="' . htmlspecialchars($this->getMetaData('ogp_image')) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:image:width" content="' . htmlspecialchars($width) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:image:height" content="' . htmlspecialchars($height) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:image:alt" content="' . htmlspecialchars($this->getMetaData('ogp_image_alt')) . '" />' . "\n";
        $str .= "\t" . '<meta property="og:image:type" content="' . htmlspecialchars($type) . '" />' . "\n";
        $str .= "\t" . '<meta property="article:published_time" content="' . htmlspecialchars($formattedPublishedTime) . '" />' . "\n";
        $str .= "\t" . '<meta property="article:modified_time" content="' . htmlspecialchars($formattedModifiedTime) . '" />' . "\n";
        $str .= "\t" . '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        $str .= "\t" . '<meta name="twitter:title" content="' . htmlspecialchars($this->getMetaData('ogp_title')) . '" />' . "\n";
        $str .= "\t" . '<meta name="twitter:description" content="' . htmlspecialchars($this->getMetaData('ogp_description')) . '" />' . "\n";
        $str .= "\t" . '<meta name="twitter:image" content="' . htmlspecialchars($this->getMetaData('ogp_image')) . '" />' . "\n";
//        $str .= "\t" . '<meta name="twitter:label1" content="Written by" />' . "\n";
//        $str .= "\t" . '<meta name="twitter:data1" content="admin" />' . "\n";
//        $str .= "\t" . '<meta name="twitter:label2" content="Time to read" />' . "\n";
//        $str .= "\t" . '<meta name="twitter:data2" content="1 minute" />' . "\n";
        $str .= "\t" . '<!-- end seo -->' . "\n";

        return $str;
    }

    public function setSeoScript($script)
    {
        $this->seoScript = $script;
    }

    public function getSeoScript()
    {
        return $this->seoScript ?? null;
    }

}
