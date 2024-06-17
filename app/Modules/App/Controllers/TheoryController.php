<?php

namespace App\Modules\App\Controllers;

use App\Modules\App\Models\Menu;
use App\Modules\App\Models\MenuShow;
use App\Modules\App\Models\Theory;
use App\Modules\Home\Models\Banner;
use App\Modules\Product\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TheoryController extends Controller
{
    public function getSingle(Request $request, $slug)
    {
        $currentUrl = $request->url();
        $urlSegments = explode('/', $currentUrl);
        $menuSlug = array_slice($urlSegments, -2, 1);
        $menu = Menu::where('slug', $menuSlug[0])->first();

        $products_related = Product::where('status', 1)->whereIn('order', [0, 1, 2, 3, 4, 5])->orderBy('order', 'ASC')->skip(0)->take(20)->get();
        $products = Product::where('order', '=', 'ASC')->paginate(6);
        $theory = Theory::where('slug', '=', $slug)->first();
        $theory_relate = Theory::where('status', '=', 1)->where('slug', '!=', $slug)->orderBy('order', '=', 'ASC')->paginate(6);

        // meta
        app('metaTagManager')->setMetaData([
            'meta_title' => $theory->name,
            'meta_description' => $theory->description,
            'meta_keywords' => $theory->name,
            'ogp_title' => $theory->name,
            'ogp_description' => $theory->description,
            'ogp_image' => config('app.PATH_ADMIN') . $theory->image,
        ]);

        return view('App::Theory.single', ['theory' => $theory, 'theory_relate' => $theory_relate, 'products' => $products, 'products_related' => $products_related, 'menu' => $menu]);
    }

    public function getList(Request $request) {
        $currentUrl = $request->url();
        $urlSegments = explode('/', $currentUrl);
        $Slug = end($urlSegments);

        $menu = Menu::where('slug', $Slug)->firstOrFail();
        $subMenuIds = Menu::getAllSubMenuIds($menu->id);
        $subMenuIds = array_unique($subMenuIds);

        $query = Theory::where('status', 1);
        $query->whereIn('id', function ($query) use ($subMenuIds) {
            $query->select('menu_show_type_id')
                ->from('app_menu_show')
                ->where('menu_show_type', MenuShow::THEORY_MENU_SHOW_TYPE)
                ->whereIn('menu_id', $subMenuIds);
        });

        $queryBlogIsMain = $query;

        $theoryIsMain = $queryBlogIsMain->orderBy('updated_at', 'DESC')->first();

        $query->whereNotIn('id', [$theoryIsMain->id]);
        $theory = $query->orderBy('created_at', 'DESC')->paginate(100);

        $theory_relate = Theory::where('status', '=', 1)->inRandomOrder()->limit(20)->get();

        // meta
        app('metaTagManager')->setMetaData([
            'meta_title' => $menu->name,
            'meta_keywords' => $menu->name,
            'ogp_title' => $menu->name,
        ]);

        return view('App::Theory.list', compact('theory', 'menu', 'theory_relate', 'theoryIsMain'));
    }
}