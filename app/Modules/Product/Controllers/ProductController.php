<?php
namespace App\Modules\Product\Controllers;

use App\Modules\Comment\Models\Comment;
use App\Modules\Footer\Models\Footer;
use App\Modules\Home\Models\Banner;
use App\Modules\Home\Models\Brand;
use App\Modules\Home\Models\Commitment;
use App\Modules\Home\Models\HomeSetting;
use App\Modules\Home\Models\Menu;
use App\Modules\Order\Models\Order;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductReview;
use App\Modules\Product\Models\UsersModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Description;


class ProductController extends Controller{
    public function getSingle(Request $request, $slug){
        $menu = null;
        $product = Product::where('slug', '=', $slug)->first();

        if (empty($product)) {
            return view('Page::404');
        }

        $commitment = null;
        $brand_all = null;
        $homeCommitment = HomeSetting::where('status', 1)->where('home_setting_type', HomeSetting::HOME_PAGE)->where('item_type', HomeSetting::COMMITMENT_TYPE)->first();
        $homeBrand = HomeSetting::where('status', 1)->where('home_setting_type', HomeSetting::HOME_PAGE)->where('item_type', HomeSetting::BRAND_TYPE)->first();
        if (!empty($homeCommitment)) {
            $commitment = Commitment::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->get();
        }
        if (!empty($homeBrand)) {
            $brand_all = Brand::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->paginate(25);
        }
        $products_related = \App\Modules\Product\Models\Product::where('status', 1)
            ->whereNotNull('selling_order')
            ->orderBy('selling_order')
            ->paginate(12);

        $products_new = Product::where('status', 1)->orderBy('created_at', 'DESC')->paginate(8);

        $contact = HomeSetting::where('status', 1)->where('home_setting_type', HomeSetting::HOME_PAGE)->where('item_type', HomeSetting::CONTACT_TYPE)->first();

        // meta
        $image = $product->image;
        $images = json_decode($product->images);

        if (is_array($images) && !empty($images) && empty($image)) {
            $image = reset($images);
        }

        if (empty($images) || count($images) == 0 || count($images) == 1 && empty($images[0])) {
            $images = [$image];
        }

        if ($product->seoMeta) {
            app('metaTagManager')->setMetaData([
                'ogp_article' => 'product',
                'meta_title' => $product->seoMeta->meta_title,
                'meta_description' => $product->seoMeta->meta_description,
                'meta_keywords' => $product->seoMeta->meta_title,
                'robots' => $product->seoMeta->getRobot(),
                'canonical' => $product->seoMeta->getCanonical(),
                'ogp_title' => $product->seoMeta->meta_title,
//                'ogp_url' => $product->seoMeta->meta_url,
                'ogp_description' => $product->seoMeta->meta_description,
                'ogp_image' => $product->seoMeta->meta_image ? config('app.PATH_ADMIN') . $product->seoMeta->meta_image : config('app.PATH_ADMIN') . $product->image,
                'ogp_image_alt' => $product->name,
                'article_section' => $product->menu ? Menu::find($product->menu)->name : '',
                'article_published_time' => $product->created_at,
                'article_modified_time' => $product->updated_at,
            ]);
            app('metaTagManager')->setSeoScript($product->seoMeta->header_script);
        }else {
            app('metaTagManager')->setMetaData([
                'ogp_article' => 'product',
                'meta_title' => $product->name,
                'meta_description' => $product->description,
                'meta_keywords' => $product->name,
                'ogp_title' => $product->name,
                'ogp_description' => $product->description,
                'ogp_image' => config('app.PATH_ADMIN') . $image,
                'ogp_image_alt' => $product->name,
                'article_section' => $product->menu ? Menu::find($product->menu)->name : '',
                'article_published_time' => $product->created_at,
                'article_modified_time' => $product->updated_at,
            ]);
        }

        return view('Product::single', ['product' => $product, 'products_related' => $products_related,
            'menu' => $menu, 'commitment' => $commitment, 'products_new' => $products_new, 'brand_all' => $brand_all,
            'contact' => $contact, 'images' => $images]);
    }

    public function getList(Request $request, $menu = null) {
        $currentUrl = $request->url();
        $urlSegments = explode('/', $currentUrl);
        $Slug = end($urlSegments);

        $products_related = \App\Modules\Product\Models\Product::where('status', 1)
            ->whereNotNull('selling_order')
            ->orderBy('selling_order')
            ->paginate(6);

        $products_new = Product::where('status', 1)->orderBy('created_at', 'DESC')->skip(0)->take(6)->get();
        $menu_list = Menu::where('parent', '=', NULL)->where('status', '=', 1)
            ->where('item_type', Menu::PRODUCT_TYPE)
            ->with(['children' => function ($query) {
                $query->orderBy('order', 'asc');
                $query->with(['children' => function ($query) {
                    $query->orderBy('order', 'asc');
                }]);
            }])
            ->orderBy('position', 'ASC')
            ->orderBy('order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();

        $commitment = null;
        $brand_all = null;
        $homeCommitment = HomeSetting::where('status', 1)->where('home_setting_type', HomeSetting::HOME_PAGE)->where('item_type', HomeSetting::COMMITMENT_TYPE)->first();
        $homeBrand = HomeSetting::where('status', 1)->where('home_setting_type', HomeSetting::HOME_PAGE)->where('item_type', HomeSetting::BRAND_TYPE)->first();
        if (!empty($homeCommitment)) {
            $commitment = Commitment::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->get();
        }
        if (!empty($homeBrand)) {
            $brand_all = Brand::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->paginate(25);
        }
        $banner = Banner::where('type', 'product')->where('status', 1)->orderBy('order', 'ASC')->skip(0)->take(6)->get();
        $contact = HomeSetting::where('status', 1)->where('home_setting_type', HomeSetting::HOME_PAGE)->where('item_type', HomeSetting::CONTACT_TYPE)->first();

        $query = Product::where('status', 1);
        $subMenuIds = [];
        if ($menu !== null) {
            $menu = Menu::where('slug', $menu)->firstOrFail();
            $subMenuIds = Menu::getAllSubMenuIds($menu->id);
            $subMenuIds = array_unique($subMenuIds);
            $query->whereIn('id', function ($query) use ($subMenuIds) {
                $query->select('product_id')
                    ->from('menu_product')
                    ->whereIn('menu_id', $subMenuIds);
            });
        }else if($Slug != 'tat-ca-san-pham' && $Slug != 'san-pham-moi') {
            $menu = Menu::where('slug', $Slug)->firstOrFail();
            $subMenuIds = Menu::getAllSubMenuIds($menu->id);
            $subMenuIds = array_unique($subMenuIds);
            $query->whereIn('id', function ($query) use ($subMenuIds) {
                $query->select('product_id')
                    ->from('menu_product')
                    ->whereIn('menu_id', $subMenuIds);
            });
        }
        if (isset($request->search)) {
            $searchTerm = trim($request->search);
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        if (isset($request->price_from) && isset($request->price_to)) {
            $query->whereBetween('price_regular', [$request->price_from, $request->price_to]);
        }
        if (isset($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }

        if (isset($request->orderby)) {
            if ($request->orderby == 'date-desc') {
                $query->orderBy('created_at', 'DESC');
            } elseif ($request->orderby == 'date') {
                $query->orderBy('created_at', 'ASC');
            } elseif ($request->orderby == 'price') {
                $query->orderByRaw('COALESCE(price_sale, price_regular) ASC');
            } elseif ($request->orderby == 'price-desc') {
                $query->orderByRaw('COALESCE(price_sale, price_regular) DESC');
            }
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $products = $query->paginate(24);
        $request->flash();

        if (!empty($menu)) {
            $brands = $menu->brands;
        }else {
            $brands = Brand::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->paginate(48);
        }
        if (!empty($menu)) {
            $menuId = $menu->id;
            $banner = Banner::where('status', 1)->whereHas('menus', function ($query) use ($menuId) {
                $query->where('banner_show_type_id', $menuId)
                    ->where('banner_show_type', Banner::MENU_BANNER_SHOW_TYPE);
            })->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->get();
        }

        // meta
        $metas = [
            'meta_title' => "Tất cả sản phẩm",
            'ogp_title' => "Tất cả sản phẩm",
        ];
        if (!empty($searchTerm)) {
            $metas = [
                'meta_title' => $searchTerm,
                'meta_keywords' => $searchTerm,
                'ogp_title' => $searchTerm,
            ];
        }elseif (!empty($menu)) {
            $metas = [
                'meta_title' => $menu->name,
                'meta_keywords' => $menu->name,
                'ogp_title' => $menu->name,
            ];
        }
        $metas['ogp_article'] = 'collection';
        app('metaTagManager')->setMetaData($metas);

        return view('Product::list', ['products' => $products, 'banners' => $banner, 'products_related' => $products_related, 'menu' => $menu, 'menu_list' => $menu_list, 'products_new' => $products_new, 'commitment' => $commitment, 'brands' => $brands, 'contact' => $contact, 'brand_all' => $brand_all]);
    }

    public function getSelling(Request $request) {

        $products = Product::where('status', 1)
            ->whereNotNull('selling_order')
            ->orderBy('selling_order')
            ->paginate(100);
        $request->flash();

        $commitment = Commitment::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->get();
        $brand_all = Brand::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->get();

        // meta
        $metas = [
            'meta_title' => "Tất cả sản phẩm",
            'ogp_title' => "Tất cả sản phẩm",
        ];
        if (!empty($searchTerm)) {
            $metas = [
                'meta_title' => $searchTerm,
                'meta_keywords' => $searchTerm,
                'ogp_title' => $searchTerm,
            ];
        }
        $metas['ogp_article'] = 'collection';
        app('metaTagManager')->setMetaData($metas);

        return view('Product::listProduct', ['products' => $products, 'brand_all' => $brand_all, 'commitment' => $commitment]);
    }

    public function commentSingle(Request $request){
        Comment::create(array(
            'product_id' => $request->product_id,
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
            'product_id' => $request->product_id,
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

    public function cartProduct(){
        return view('Product::cart');
    }

    public function addToCart(Request $request){
        if(!empty(session()->get('mini_cart'))){
            $carts = session()->get('mini_cart');
            $key_arr = NULL;
            $qty_arr = NULL;
            $check = false;
            foreach ($carts as $key => $cart){
                if($cart['id'] == $request->buy_now){
                    $check = true;
                    $key_arr = $key;
                    $qty_arr = $cart['qty'] + $request->qty;
                }
            }

            if($check == true){
                $carts[$key_arr]['qty'] = $qty_arr;
            }else{
                $carts[] = [
                    'id' => $request->buy_now,
                    'qty' => $request->qty
                ];
            }
        }else{
            $carts = [];
            $carts[] = [
                'id' => $request->buy_now,
                'qty' => $request->qty
            ];
        }

        session()->put('mini_cart', $carts);

        return Redirect::to('/gio-hang');
    }

    public function addToCartNew(Request $request){
        if(!empty(session()->get('mini_cart'))){
            $carts = session()->get('mini_cart');
            $key_arr = NULL;
            $qty_arr = NULL;
            $check = false;
            foreach ($carts as $key => $cart){
                if($cart['id'] == $request->buy_now){
                    $check = true;
                    $key_arr = $key;
                    $qty_arr = $cart['qty'] + $request->qty;
                }
            }

            if($check == true){
                $carts[$key_arr]['qty'] = $qty_arr;
            }else{
                $carts[] = [
                    'id' => $request->buy_now,
                    'qty' => $request->qty
                ];
            }
        }else{
            $carts = [];
            $carts[] = [
                'id' => $request->buy_now,
                'qty' => $request->qty
            ];
        }

        session()->put('mini_cart', $carts);

        return Redirect::back()->with('success', 'Thêm giỏ thành công !');
    }

    public function updateToCart(Request $request){
        if(!empty(session()->get('mini_cart'))){
            session()->put('mini_cart', $request->carts);
        }
        return Redirect::to('/gio-hang');
    }

    public function removeCart($id){
        $carts = session()->get('mini_cart');
        unset($carts[$id]);

        session()->put('mini_cart', $carts);

        return Redirect::to('/gio-hang');
    }

    public function checkOut(){
        if(!empty(session()->get('mini_cart'))){
            if(isset($_GET['order'])){
                session()->put('mini_cart', []);
            }
            $bankAccountInfo = Footer::find(1)->bank_account;
            $bankAccountInfo = str_replace('src="images/', 'src="' . Config::get('app.PATH_ADMIN') . '/images/', $bankAccountInfo);
            return view('Product::checkout', compact('bankAccountInfo'));
        }else{
            return Redirect::to('/gio-hang');
        }
    }

    public function postCheckOut(Request $request){
//        $userCheck = UsersModel::where('ma_gioi_thieu', $request->ma_gioi_thieu)->first();
//        if($request->ma_gioi_thieu == '' || $userCheck == null){
//            return Redirect::back()->with('error', 'Mã giới thiệu không đúng!');
//        }

        $carts = [];
        if(!empty(session()->get('mini_cart'))){
            $carts = session()->get('mini_cart');
        }

        $carts = json_encode($carts);

        $order = Order::create(array(
//            'ma_gioi_thieu' => $request->ma_gioi_thieu,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'pay' => $request->type_bank,
            'note' => $request->note,
            'products' => $carts,
            'status' => 0,
        ));

        $order_save = Order::find($order->id);
        $order_save->code = 'PM_'.$order->id;
        $order_save->save();

        return Redirect::to(route('product.checkout').'?order=PM_'.$order->id);
    }

    public function nhapMaGioiThieu(Request $request){
        $return = "";
        $allData = UsersModel::where('ma_gioi_thieu', 'like', '%' . $request->get('search') . '%')
            ->limit(20)->get()->toArray();
        foreach ($allData as $key => $item) {
            $return .= "<li onclick='chonMaGioiThieu(this, " . $item['ma_gioi_thieu'] . ")'>" . $item['ma_gioi_thieu'] . "</li>";
        }
        echo $return;
    }

    // api
    public function apiGetList(Request $request, $menu = null) {
        $currentUrl = $request->url();
        $urlSegments = explode('/', $currentUrl);
        $Slug = end($urlSegments);

        $banner = Banner::where('type', 'product')->where('status', 1)->orderBy('order', 'ASC')->skip(0)->take(6)->get();

        $query = Product::where('status', 1);
        $subMenuIds = [];
        if ($menu !== null) {
            $menu = Menu::where('slug', $menu)->firstOrFail();
            $subMenuIds = Menu::where('parent', $menu->id)->pluck('id')->toArray();
            array_push($subMenuIds, $menu->id);
            $query->whereIn('menu', $subMenuIds);
        }else if($Slug != 'tat-ca-san-pham') {
            $menu = Menu::where('slug', $Slug)->firstOrFail();
            $subMenuIds = Menu::where('parent', $menu->id)->pluck('id')->toArray();
            array_push($subMenuIds, $menu->id);
            $query->whereIn('menu', $subMenuIds);
        }

        if (isset($_GET['search'])) {
            $searchTerm = trim($_GET['search']);
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        if (isset($request->orderby)) {
            if ($request->orderby == 'date-desc') {
                $query->orderBy('created_at', 'DESC');
            } elseif ($request->orderby == 'date') {
                $query->orderBy('created_at', 'ASC');
            } elseif ($request->orderby == 'price') {
                $query->orderByRaw('COALESCE(price_sale, price_regular) ASC');
            } elseif ($request->orderby == 'price-desc') {
                $query->orderByRaw('COALESCE(price_sale, price_regular) DESC');
            }
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $products = $query->paginate(100);

        return response()->json($products);
    }

    public function storeReview(Request $request, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'star' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
        ]);

        if ($validator->passes()) {
            $user = auth()->user();

            $path = '/images/products/reviews/';
            $path_upload = public_path($path);
            $imagePaths = [];

            if($request->hasfile('images')){
                if (!file_exists($path_upload)) {
                    mkdir($path_upload, 0777, true);
                }
                $images = $request->file('images');
                foreach ($images as $image) {
                    $fileName = time().rand(1,100).$image->getClientOriginalName();
                    $image->move($path_upload, $fileName);
                    $imagePaths[] = config('app.url').'public'.$path.$fileName;
                }
            }

            ProductReview::create([
                'product_id' => $product_id,
                'user_id' => $user->id,
                'star' => $request->input('star'),
                'images' => json_encode($imagePaths),
                'content' => $request->input('content'),
            ]);
        }

        return redirect()->back();
    }
}