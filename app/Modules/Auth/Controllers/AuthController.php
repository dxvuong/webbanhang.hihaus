<?php
namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Home\Models\ProvinceModel;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 * @package App\Modules\Auth\Controllers
 */
class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function loginForm(){
        if (Auth::check()) {
            return redirect()->back();
        }

        return view('Auth::login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
                if ($user->is_delete == 1) {
                    return response()->json(['status' => 'false', 'message' => "Tài khoản đã bị xóa, vui lòng liên hệ tổng đài để được kích hoạt."]);
                }
                if(Auth::attempt(['email' => $user->email, 'password' => $password], $request->remember)){
                    return response()->json(['status' => 'true', 'message' => "Đăng nhập thành công."]);
                }
            }
            return response()->json(['status' => 'false', 'message' => "Sai tài khoản hoặc mật khẩu."]);
        }
        return response()->json(['status' => 'false', 'message' => $validator->errors()->first()]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function signupForm()
    {
        app('metaTagManager')->setMetaData([
            'meta_title' => 'Đăng Ký',
            'meta_keywords' => 'Đăng Ký',
            'ogp_title' => 'Đăng Ký',
        ]);
        if (Auth::check()) {
            return redirect()->back();
        }
        $allProvince = ProvinceModel::where('provice_status', 1)->get()->toArray();
        return view('Auth::register', ['allProvince' => $allProvince]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'login_name' => 'required|string|max:255|unique:users',
            'phone' => 'required|numeric|min:0|max:999999999|unique:users',
            'password' => 'required|string',
            'password_confirm' => 'required|same:password',
            'bank_account_number' => 'max:32',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được dài hơn 255 ký tự.',
            'email.unique' => 'Địa chỉ email này đã được sử dụng.',

            'login_name.required' => 'Vui lòng nhập tên đăng nhập.',
            'login_name.max' => 'Tên đăng nhập không được dài hơn 255 ký tự.',
            'login_name.unique' => 'Tên đăng nhập này đã được sử dụng.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.min' => 'Số điện thoại phải lớn hơn hoặc bằng 0.',
            'phone.max' => 'Số điện thoại không được dài hơn 10 ký tự.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',

            'password.required' => 'Vui lòng nhập mật khẩu.',

            'password_confirm.required' => 'Vui lòng xác nhận mật khẩu.',
            'password_confirm.same' => 'Mật khẩu xác nhận không khớp với mật khẩu đã nhập.',

            'bank_account_number.max' => 'Số tài khoản không được dài hơn 32 ký tự.',
        ]);
        if ($validator->passes()) {
            $request['password'] = bcrypt($request['password']);

            $expensions_images = array("jpeg","jpg","png",'gif','svg','webp');
            $path = '/images/user/';
            $path_upload = public_path($path);

            $avatar = '';
            $bank_account_image = '';

            if($request->hasfile('avatar')){
                if (!file_exists($path_upload)) {
                    mkdir($path_upload, 0777, true);
                }
                $file = $request->file('avatar');
                if(in_array($file->getClientOriginalExtension(),$expensions_images)){
                    $fileName = time().rand(1,100).$file->getClientOriginalName();
                    $file->move($path_upload, $fileName);
                    $avatar = config('app.url').'public'.$path.$fileName;
                }
            }

            if($request->hasfile('bank_account_image')){
                if (!file_exists($path_upload)) {
                    mkdir($path_upload, 0777, true);
                }
                $file = $request->file('bank_account_image');
                if(in_array($file->getClientOriginalExtension(),$expensions_images)){
                    $fileName = time().rand(1,100).$file->getClientOriginalName();
                    $file->move($path_upload, $fileName);
                    $bank_account_image = config('app.url').'public'.$path.$fileName;
                }
            }

            $request = $request->all();
            $request['avatar'] = $avatar;
            $request['level_id'] = 2;
            $request['bank_account_image'] = $bank_account_image;

            $user = User::create($request);
            return response()->json(['status' => 'true', 'user' => $user]);
        }
        return response()->json(['status' => 'false', 'message' => $validator->errors()->first()]);
    }
}