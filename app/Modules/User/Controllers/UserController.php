<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Home\Models\ProvinceModel;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class AuthController
 * @package App\Modules\Auth\Controllers
 */
class UserController extends Controller
{
    public function detail(Request $request) {
        if (Auth::check()) {
            $user = Auth::user();
            $allProvince = ProvinceModel::where('provice_status', 1)->get()->toArray();
            return view('User::detail', ['user' => $user, 'allProvince' => $allProvince]);
        } else {
            return redirect()->route('user.login');
        }
    }

    public function postUpdateUser(Request $request)
    {
        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id)
                ],
                'login_name' => [
                    'required',
                    'max:255',
                    Rule::unique('users')->ignore($user->id)
                ],
                'phone' => [
                    'required',
                    'numeric',
                    'max:999999999',
                    Rule::unique('users')->ignore($user->id)
                ],
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
                'phone.max' => 'Số điện thoại không được dài hơn 10 ký tự.',
                'phone.unique' => 'Số điện thoại này đã được sử dụng.',

                'bank_account_number.max' => 'Số tài khoản không được dài hơn 32 ký tự.',
            ]);
            if ($validator->passes()) {

                $expensions_images = array("jpeg","jpg","png",'gif','svg','webp');
                $path = '/images/user/';
                $path_upload = public_path($path);

                $avatar = $request['avatar'];
                $bank_account_image = $request['bank_account_image'];

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
                $request['bank_account_image'] = $bank_account_image;

                $user = $user->update($request);
                return response()->json(['status' => 'true', 'user' => $user]);
            }
            return response()->json(['status' => 'false', 'message' => $validator->errors()->first()]);
        } else {
            return response()->json(['status' => 'false', 'message' => "Chưa đăng nhập!"]);
        }
    }
}