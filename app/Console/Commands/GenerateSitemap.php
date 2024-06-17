<?php

namespace App\Console\Commands;

use App\Modules\Blog\Models\Blog;
use App\Modules\Home\Models\Menu;
use App\Modules\Home\Models\SeoSetting;
use App\Modules\Product\Models\Product;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap and update robots.txt';

    protected $seoSetting = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info('Generating sitemap...');
        $this->seoSetting = SeoSetting::find(1);

        // Tạo sitemap
        $sitemap = Sitemap::create();

        // Thêm URL Home
        $sitemap->add(Url::create(\url('/'))->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)->setPriority($this->seoSetting->home_sitemap_priority));

        // Thêm URL của menu bài viết
        Menu::where('item_type', Menu::BLOG_TYPE)->get()->each(function ($menu) use ($sitemap) {
            $url = url($menu->link);
            $sitemap->add(Url::create($url)->setLastModificationDate($menu->updated_at)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)->setPriority($this->seoSetting->blog_menu_sitemap_priority));
        });

        // Thêm URL của menu sản phẩm
        Menu::where('item_type', Menu::PRODUCT_TYPE)->get()->each(function ($menu) use ($sitemap) {
            $url = url($menu->link);
            $sitemap->add(Url::create($url)->setLastModificationDate($menu->updated_at)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)->setPriority($this->seoSetting->product_menu_sitemap_priority));
        });

        // Thêm URL của bài viết
        Blog::all()->each(function ($blog) use ($sitemap) {
            $url = $blog->generateURL();
            $sitemap->add(Url::create($url)->setLastModificationDate($blog->updated_at)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)->setPriority($this->seoSetting->blog_sitemap_priority));
        });

        // Thêm URL của sản phẩm
        Product::all()->each(function ($product) use ($sitemap) {
            $url = $product->generateURL();
            $sitemap->add(Url::create($url)->setLastModificationDate($product->updated_at)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)->setPriority($this->seoSetting->product_sitemap_priority));
        });

        // Ghi sitemap vào file
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');

        // Cập nhật robots.txt
        $this->info('Updating robots.txt...');
        $this->updateRobotsTxt();
        $this->info('robots.txt updated successfully!');
    }

    protected function updateRobotsTxt()
    {
        $robotsTxtPath = base_path('robots.txt');

        // Đảm bảo rằng robots.txt đã tồn tại
        if (!file_exists($robotsTxtPath)) {
            $this->error('robots.txt not found!');
            return;
        }

        $currentContent = $this->seoSetting->robots_txt;

        file_put_contents($robotsTxtPath, $currentContent);

        $this->info('robots.txt updated successfully!');
    }
}
