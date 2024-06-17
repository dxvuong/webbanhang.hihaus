<?php

namespace App\Modules\Blog\Controllers;

use App\Modules\Blog\Models\Blog;
use App\Modules\Comment\Models\Comment;
use App\Modules\Event\Models\Event;
use App\Modules\Home\Models\Banner;
use App\Modules\Home\Models\Menu;
use App\Modules\Product\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function getSingle(Request $request, $slug)
    {
        $currentUrl = $request->url();
        $urlSegments = explode('/', $currentUrl);
        $menuSlug = array_slice($urlSegments, -2, 1);
        $menu = Menu::where('slug', $menuSlug[0])->first();

        $products_related = Product::where('status', 1)->whereIn('order', [0, 1, 2, 3, 4, 5])->orderBy('order', 'ASC')->skip(0)->take(20)->get();
        $banner = Banner::where('type', '=', 'blog_detail')->where('status', '=', 1)->orderBy('order', '=', 'ASC')->first();
        $products = Product::where('order', '=', 'ASC')->paginate(6);
        $blog = Blog::where('slug', '=', $slug)->first();
        $blog_relate = Blog::where('status', '=', 1)->inRandomOrder()->limit(20)->get();

        if ($blog->seoMeta) {
            app('metaTagManager')->setMetaData([
                'meta_title' => $blog->seoMeta->meta_title,
                'meta_description' => $blog->seoMeta->meta_description,
                'meta_keywords' => $blog->seoMeta->meta_title,
                'robots' => $blog->seoMeta->getRobot(),
                'canonical' => $blog->seoMeta->getCanonical(),
                'ogp_title' => $blog->seoMeta->meta_title,
//                'ogp_url' => $blog->seoMeta->meta_url,
                'ogp_description' => $blog->seoMeta->meta_description,
                'ogp_image' => $blog->seoMeta->meta_image ? config('app.PATH_ADMIN') . $blog->seoMeta->meta_image : config('app.PATH_ADMIN') . $blog->image,
                'ogp_image_alt' => $blog->name,
                'article_section' => $blog->menu ? Menu::find($blog->menu)->name : '',
                'article_published_time' => $blog->created_at,
                'article_modified_time' => $blog->updated_at,
            ]);
            app('metaTagManager')->setSeoScript($blog->seoMeta->header_script);
        }else {
            app('metaTagManager')->setMetaData([
                'meta_title' => $blog->name,
                'meta_description' => $blog->description,
                'meta_keywords' => $blog->name,
                'ogp_title' => $blog->name,
                'ogp_description' => $blog->description,
                'ogp_image' => config('app.PATH_ADMIN') . $blog->image,
                'ogp_image_alt' => $blog->name,
                'article_section' => $blog->menu ? Menu::find($blog->menu)->name : '',
                'article_published_time' => $blog->created_at,
                'article_modified_time' => $blog->updated_at,
            ]);
        }

        return view('Blog::single', ['blog' => $blog, 'blog_relate' => $blog_relate, 'products' => $products, 'banner' => $banner, 'products_related' => $products_related, 'menu' => $menu]);
    }

    public function getList(Request $request, $menu = null) {
        $currentUrl = $request->url();
        $urlSegments = explode('/', $currentUrl);
        $Slug = end($urlSegments);

        $query = Blog::where('status', 1);

        $subMenuIds = [];
        if ($menu !== null) {
            $menu = Menu::where('slug', $menu)->firstOrFail();
            $subMenuIds = Menu::getAllSubMenuIds($menu->id);
            $subMenuIds = array_unique($subMenuIds);
        }else {
            $menu = Menu::where('slug', $Slug)->firstOrFail();
            $subMenuIds = Menu::getAllSubMenuIds($menu->id);
            $subMenuIds = array_unique($subMenuIds);
        }
        $query->whereIn('id', function ($query) use ($subMenuIds) {
            $query->select('blog_id')
                ->from('menu_blog')
                ->whereIn('menu_id', $subMenuIds);
        });

        $queryBlogIsMain = $query;

        $blog = $query->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->paginate(100);
        $blogIsMain = $queryBlogIsMain->where('is_main', '=', 1)->orderBy('updated_at', 'DESC')->first();

        if (empty($blogIsMain)) {
            $blogIsMain = Blog::where('status', '=', 1)->where('is_main', '=', 1)->orderBy('updated_at', 'DESC')->first();
        }
        $blog_relate = Blog::where('status', '=', 1)->inRandomOrder()->limit(20)->get();

        // meta
        app('metaTagManager')->setMetaData([
            'meta_title' => $menu->name,
            'meta_keywords' => $menu->name,
            'ogp_title' => $menu->name,
        ]);

        return view('Blog::list', compact('blog', 'menu', 'blog_relate', 'blogIsMain'));
    }

    public function getServiceSingle($slug){
        $id_check = Menu::where('slug', '=', $slug)->count();
        if($id_check > 0){
            $id = Menu::where('slug', '=', $slug)->first()->id;
            $blog = Blog::where('menu', '=', $id)->orderBy('order', '=', 'ASC')->paginate(9);
            $event_wait = Event::where('status', '=', 1)->where('event', '=', 0)->orderBy('order', '=', 'ASC')->skip(0)->take(6)->get();
            return view('Blog::list-cate', compact( 'blog', 'event_wait'));
        }else{
            return Redirect::to('/');
        }
    }

    public function commentSingle(Request $request){
        Comment::create(array(
            'blog_id' => $request->product_id,
            'gender' => $request->gender,
            'name' => $request->author,
            'phone' => $request->phone,
            'email' => $request->email,
            'content' => $request->content_comment,
            'status' => 0,
        ));

        return \redirect()->to($request->product_slug.'#comment')->with('comment', 'Bình luận của bạn đang chờ kiểm duyệt!');
    }

    public function commenChildtSingle(Request $request){
        Comment::create(array(
            'blog_id' => $request->product_id,
            'gender' => $request->gender,
            'name' => $request->author,
            'phone' => $request->phone,
            'email' => $request->email,
            'content' => $request->content_comment,
            'parent' => $request->parent_id,
            'status' => 0,
        ));

        return \redirect()->to($request->product_slug.'#comment')->with('comment', 'Bình luận của bạn đang chờ kiểm duyệt!');
    }
}