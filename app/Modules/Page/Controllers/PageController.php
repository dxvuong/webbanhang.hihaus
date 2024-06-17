<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/
namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Models\Blog;
use App\Modules\Event\Models\Event;
use App\Modules\Page\Models\Contact;
use App\Modules\Page\Models\Page;
use App\Modules\Page\Models\QuoteAndPromotion;
use App\Modules\Page\Models\Warranty;
use App\Modules\Product\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller{
    public function getAbout(){
        $page = Page::find(1);
        $blog = Blog::whereIn('order', [0,1,2,3,4,5])->orderBy('order', '=', 'ASC')->get();
        $blog_relate = Blog::where('status', '=', 1)->inRandomOrder()->limit(20)->get();

        // meta
        app('metaTagManager')->setMetaData([
            'meta_title' => $page->title,
            'meta_description' => $page->description,
            'meta_keywords' => $page->title,
            'ogp_title' => $page->title,
            'ogp_description' => $page->description,
        ]);

        return view('Page::about', ['page' => $page, 'blog' => $blog, 'blog_relate' => $blog_relate]);
    }
    public function getContact(){
        $products_related = Product::where('status', 1)->whereIn('order', [0, 1, 2, 3, 4, 5])->orderBy('order', 'ASC')->skip(0)->take(20)->get();
        $page = Page::find(2);
        $blog = Blog::whereIn('order', [0,1,2,3,4,5])->orderBy('order', '=', 'ASC')->get();

        // meta
        app('metaTagManager')->setMetaData([
            'meta_title' => "Liên hệ",
            'ogp_title' => "Liên hệ",
        ]);

        return view('Page::contact', ['page' => $page, 'blog' => $blog, 'products_related' => $products_related]);
    }
    public function get404(){
        // meta
        app('metaTagManager')->setMetaData([
            'meta_title' => 'Trang 404',
            'ogp_title' => 'Trang 404',
        ]);
        return view('Page::404');
    }

    public function postLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'account' => 'required',
            'password' => 'required',
        ], [
            'account.required' => 'Vui lòng nhập tài khoản.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);
        if ($validator->passes()) {
            $account = $request->account;
            $password = $request->password;

            $user = User::where('email', $account)
                ->orWhere('phone', $account)
                ->orWhere('login_name', $account)
                ->first();

            if ($user != null) {
                if(Auth::attempt(['email' => $user->email, 'password' => $password], $request->remember)){
                    return response()->json(['status' => 'true', 'message' => "Đăng nhập thành công."]);
                }
            }
            return response()->json(['status' => 'false', 'message' => "Sai tài khoản hoặc mật khẩu."]);
        }
        return response()->json(['status' => 'false', 'message' => $validator->errors()->first()]);
    }

    public function postContact(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|min:0',
            'name' => 'required',
        ], [
            'phone.required' => 'Enter your phone number.',
        ]);
        $request = $request->all();

        if ($validator->passes()) {
            $request['status'] = 0;
            if (empty($request['subject'])) {
                $request['subject'] = '';
            }
            if (empty($request['content'])) {
                $request['content'] = '';
            }

            Contact::create($request);

            return response()->json(['status' => 'true', 'message' => "Request sent successfully."]);
        }

        return response()->json(['status' => 'false', 'message' => $validator->errors()->first()]);
    }

    public function postQuoteAndPromotion(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|min:0',
            'name' => 'required',
        ], [
            'phone.required' => 'Enter your phone number.',
        ]);
        $request = $request->all();

        if ($validator->passes()) {
            $request['status'] = 0;
            $request['parameters'] = json_encode($request['parameters']);

            QuoteAndPromotion::create($request);

            return response()->json(['status' => 'true', 'message' => "Bạn đã gửi báo giá thành công."]);
        }

        return response()->json(['status' => 'false', 'message' => $validator->errors()->first()]);
    }

    public function getWarrantyPolicy(){
        $page = Page::where('slug', 'chinh-sach-bao-hanh')->first();

        // meta
        app('metaTagManager')->setMetaData([
            'meta_title' => "Chính sách bảo hành",
            'ogp_title' => "Chính sách bảo hành",
        ]);

        return view('Page::warrantyPolicy', ['page' => $page]);
    }

    public function getWarrantyCheck(Request $request){
        $page = Page::where('slug', 'chinh-sach-bao-hanh')->first();

        if (empty($request->phone) && $request->search) {
            return view('Page::warrantyCheck', ['page' => $page])->with('error', 'Bạn chưa nhập số điện thoại.');
        }
        $warranties = null;
        if (!empty($request->phone)) {
            $warranties = Warranty::where('payer_phone', $request->phone)->get();
            if ($warranties->isEmpty()) {
                return view('Page::warrantyCheck', ['page' => $page])->with('error', 'Thông tin số điện thoại của bạn chưa được đăng kí bảo hành.');
            }
        }

        return view('Page::warrantyCheck', ['page' => $page, 'warranties' => $warranties]);
    }
}