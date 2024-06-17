<?php
namespace App\Modules\Home\Controllers;

use App\Modules\Footer\Models\Footer;
use App\Modules\Home\Models\LandingPage;
use CzProject\GitPhp\GitRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use phpseclib3\Net\SSH2;
use Response;
use App\Modules\Event\Models\Event;
use App\Modules\Home\Models\Banner;
use App\Modules\Home\Models\HomeSetting;
use App\Modules\Home\Models\Menu;
use App\Modules\Product\Models\Product;
use App\Modules\Home\Models\Blog;
use App\Modules\Home\Models\ProvinceModel;
use App\Modules\Home\Models\DictrictModel;
use App\Modules\Home\Models\WardModel;
use App\Modules\Home\Models\UsersModel;
use App\Modules\Home\Models\DonHangKhachHangVipModel;
use App\Modules\Home\Models\DonHangKhachHangVipSanPhamModel;
use App\Modules\Home\Models\KhachHangVipModel;
use App\Modules\Home\Models\WProductModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller{
	public function getHome(){
		$banner = Banner::where('status', '=', 1)->whereHas('bannerShowHome')->orderBy('order', 'ASC')->get();
		$products = Product::where('status', '=', 1)->orderBy('order', '=', 'ASC')->skip(0)->take(4)->get();
		$blog = Blog::where('status', '=', 1)->orderBy('order', '=', 'ASC')->skip(0)->take(4)->get();
		$event_wait = Event::where('status', '=', 1)->where('event', '=', 0)->orderBy('order', '=', 'ASC')->skip(0)->take(4)->get();
		$event = Event::where('status', '=', 1)->where('event', '=', 1)->orderBy('order', '=', 'ASC')->skip(0)->take(4)->get();

		$homeSettings = HomeSetting::where('status', 1)->where('home_setting_type', HomeSetting::HOME_PAGE)->orderBy('order', 'ASC')->get();

		$datas = [];
		foreach ($homeSettings as $homeSetting) {
			$item = [
				'homeSetting' => $homeSetting,
				'item' => [],
			];

			if ($homeSetting->menu_id) {
				$menu = Menu::find($homeSetting->menu_id);
				if ($menu) {
					$item['item'] = $menu->itemsByType($homeSetting->item_type, $homeSetting);
				}
			}

			$datas[] = $item;
		}
        app('metaTagManager')->setMetaData([
            'ogp_article' => 'website',
        ]);

		return view('Home::home', ['banner' => $banner, 'products' => $products, 'blog' => $blog, 'event_wait' => $event_wait, 'event' => $event, 'datas' => $datas]);
	}

    public function getLandingPage(Request $request){
        $currentUrl = $request->url();
        $urlSegments = explode('/', $currentUrl);
        $urlSlug = array_slice($urlSegments, -1, 1);
        $landingPage = LandingPage::where('url', $urlSlug[0])->firstOrFail();

        $banner = Banner::where('status', '=', 1)->where('type', '=', 'landingPage')->where('banner_type',$landingPage->id)->orderBy('order', '=', 'ASC')->get();
        $products = Product::where('status', '=', 1)->orderBy('order', '=', 'ASC')->skip(0)->take(4)->get();
        $blog = Blog::where('status', '=', 1)->orderBy('order', '=', 'ASC')->skip(0)->take(4)->get();
        $event_wait = Event::where('status', '=', 1)->where('event', '=', 0)->orderBy('order', '=', 'ASC')->skip(0)->take(4)->get();
        $event = Event::where('status', '=', 1)->where('event', '=', 1)->orderBy('order', '=', 'ASC')->skip(0)->take(4)->get();

        if (!empty($landingPage)) {
            $setting = Footer::where('setting_type', $landingPage->id)->first();
            if (empty($setting)) {
                $setting = Footer::find(1);
            }
            $homeSettings = HomeSetting::where('status', 1)->where('home_setting_type', $landingPage->id)->orderBy('order', 'ASC')->get();
        }else {
            $setting = Footer::find(1);
            $homeSettings = HomeSetting::where('status', 1)->where('home_setting_type', HomeSetting::HOME_PAGE)->orderBy('order', 'ASC')->get();
        }

        $datas = [];
        foreach ($homeSettings as $homeSetting) {
            $item = [
                'homeSetting' => $homeSetting,
                'item' => [],
            ];

            if ($homeSetting->menu_id) {
                $menu = Menu::find($homeSetting->menu_id);
                if ($menu) {
                    $item['item'] = $menu->itemsByType($homeSetting->item_type, $homeSetting);
                }
            }

            $datas[] = $item;
        }

        // meta
        app('metaTagManager')->setMetaData([
            'meta_title' => $setting->company_name,
            'ogp_title' => $setting->company_name,
            'ogp_image' => config('app.PATH_ADMIN') . $setting->image,
        ]);

        return view('Home::landingPage', ['banner' => $banner, 'products' => $products, 'blog' => $blog, 'event_wait' => $event_wait, 'event' => $event, 'datas' => $datas, 'setting' => $setting]);
    }

	public function signup()
	{
		//if (Auth::check() && Auth::user()->id_loai_user == 1) {
			//return redirect("/");
		//}else{
			$allProvince = ProvinceModel::where('provice_status', 1)->get()->toArray();
			
			// dd( $allProvince );
			$data = array(
				'menu' => 'signup',
				'allProvince' => $allProvince,
				'title' => 'Đăng ký'
			);
			return view('Home::signup', $data);
		//}
	}
	public function loadQuanHuyen(Request $request)
	{
		$id_tinh = $request->get('id');
		$return = "<option value=''>--- Chọn Quận/ huyện ---</option>";
		$allDictrict = DictrictModel::where('provice_id', $id_tinh)->where('dictrict_status', 1)->get()->toArray();
		foreach ($allDictrict as $key => $quanHuyen) {
			$return .= "<option value='".$quanHuyen['dictrict_id']."' ".($request->get('dictrict_id')==$quanHuyen['dictrict_id']?'selected':'').">".$quanHuyen['dictrict_title']."</option>";
		}
		echo $return;
	}
	public function loadXaPhuong(Request $request)
	{
		$id_huyen = $request->get('id');
		$return = "<option value=''>--- Chọn Xã/ phường ---</option>";
		$allWard = WardModel::where('dictrict_id', $id_huyen)->where('ward_status', 1)->get()->toArray();
		foreach ($allWard as $key => $xaPhuong) {
			$return .= "<option value='".$xaPhuong['ward_id']."' ".($request->get('ward_id')==$xaPhuong['ward_id']?'selected':'').">".$xaPhuong['ward_title']."</option>";
		}
		echo $return;
	}
	public function signup_submit(Request $request)
	{
		$validator = Validator::make($request->all(), [
		]);
		$input = $request->all();
		if ($validator->passes()) {
			//$user_name = Helper::boDauTiengViet($request->get('user_full_name'), 1);
			$user_name = $request->get('user_name');
			$password = $request->get('password');
			$password_confirm = $request->get('password_confirm');
			if($password != $password_confirm){
				return Response::json(['status' => 'false', 'message' => 'Mật khẩu không trùng khớp.']);
			}
			$ngay_sinh = $request->get('ngay_sinh');
			$user = UsersModel::where(function ($query) use ($request,$user_name) { // where('user_rid', 12)->
					$query->orWhere('user_name', 'like', '%'.$user_name.'%');
					$query->orWhere('user_mail', 'like', '%'.$request->get('user_mail').'%');
				})->first();
			if($user == null){
				$referralUser = false;
				if($request->get('ma_gioi_thieu') != null){
					$referralUser = UsersModel::where('ma_gioi_thieu', $request->get('ma_gioi_thieu'))->first();
					if($referralUser == null){
						return Response::json(['status' => 'false', 'message' => 'Mã giới thiệu không đúng.']);
					}
					
				}
				//$referralCode = $request->get('username');
				
				## tạo ma_gioi_thieu
				$ma_gioi_thieu = "";
				$chars = "0123456789";
				for ($i = 0; $i < 6; $i++) {
					$ma_gioi_thieu = $ma_gioi_thieu.$chars[rand(0, (strlen($chars)-1))];
				}
				## check ma_gioi_thieu
				$userCheck = UsersModel::where('ma_gioi_thieu', $ma_gioi_thieu)->first();
				while($userCheck != null){
					## tạo ma_gioi_thieu
					$ma_gioi_thieu = "";
					$chars = "0123456789";
					for ($i = 0; $i < 6; $i++) {
						$ma_gioi_thieu = $ma_gioi_thieu.$chars[rand(0, (strlen($chars)-1))];
					}
					## check ma_gioi_thieu
					$userCheck = UsersModel::where('ma_gioi_thieu', $ma_gioi_thieu)->first();
					
				}
				## insert user
				$avatar = "";
				if ($request->file('avatar')){
					$path = public_path() . "/images/user/";
					if (!file_exists($path)) {
						mkdir($path, 0777, true);
					}
					$avatar = uniqid().".png";
					$request->file('avatar')->move($path, $avatar);
				}
				$userNew = UsersModel::findOrNew('');
				$userNew->ma_gioi_thieu = $ma_gioi_thieu;
				$userNew->ma_gioi_thieu_cha = $request->get('ma_gioi_thieu');
				$userNew->user_full_name = $request->get('user_full_name');
				$userNew->user_phone = $request->get('user_phone');
				$userNew->thuong_tru = $request->get('thuong_tru');
				$userNew->tam_tru = $request->get('tam_tru');
				$userNew->user_mail = $request->get('user_mail');
				$userNew->user_name = $user_name;
				$userNew->user_pass = md5($password);
				$userNew->ngan_hang = $request->get('ngan_hang');
				$userNew->so_tai_khoan = $request->get('so_tai_khoan');
				$userNew->ten_tai_khoan = $request->get('ten_tai_khoan');
				if ($referralUser != null) {
					$parent = $referralUser->child_user_ids['parent'] ?? [];
					$parent[] = $referralUser->user_id;
					$userNew->child_user_ids = [
						'child' => [],
						'parent' => $parent
					];
				}else{
					$userNew->child_user_ids = [
						'child' => [],
						'parent' => []
					];
				}				
				
				$userNew->user_image = $avatar;
				$userNew->save();

				// Lấy thông tin tài khoản cha
				
				if ($referralUser != null) {
					$list = $referralUser->child_user_ids;
					$list['child'][] = $userNew->user_id;
					$referralUser->child_user_ids = $list;
					$referralUser->save();
					if (isset($referralUser->child_user_ids['parent']) && $referralUser->child_user_ids['parent'] != null) {
						foreach($referralUser->child_user_ids['parent'] as $item){
							$referralUser = UsersModel::where('user_id', $item)->first();
							$list = $referralUser->child_user_ids;
							$list['child'][] = $userNew->user_id;
							$referralUser->child_user_ids = $list;
							$referralUser->save();
						}
					}
				}
				//return Response::json(['status' => 'false', 'message' => $userNew->user_id]);
				## insert khach_hang_vip
				$khachHangVip = KhachHangVipModel::findOrNew('');
				$khachHangVip->ma_khach_hang = "KHV-".strtoupper(uniqid());
				$khachHangVip->tong_ban = 0;
				$khachHangVip->tong_hang_tra =0;
				$khachHangVip->da_tra_tien = 0;
				$khachHangVip->no_dang_con = 0;
				//$tinh = "";
				//$province = ProvinceModel::where('provice_id', $request->get('id_tinh'))->where('provice_status', 1)->first();
				//if($province != null){
				//	$tinh = $province->provice_title;
				//}
				//$huyen = "";
				//$dictrict = DictrictModel::where('dictrict_id', $request->get('id_huyen'))->where('dictrict_status', 1)->first();
				//if($dictrict != null){
				//	$huyen = $dictrict->dictrict_title;
				//}
				//$xa = "";
				//$ward = WardModel::where('ward_id', $request->get('id_xa'))->where('ward_status', 1)->first();
				//if($ward != null){
				//	$xa = $ward->ward_title;
				//}
				$khachHangVip->ten = $request->get('name');
				$khachHangVip->phone_cong_ty = $request->get('phone');
				$khachHangVip->phone_di_dong = $request->get('phone');
				$khachHangVip->email = $request->get('email');
				//$khachHangVip->ma_so_thue = $request->get('ma_so_thue');
				$khachHangVip->dia_chi = $request->get('dia_chi');
				//$khachHangVip->xa = $xa;
				//$khachHangVip->huyen = $huyen;
				//$khachHangVip->tinh = $tinh;
				$khachHangVip->provice_id = $request->get('provice_id');
				$khachHangVip->dictrict_id = $request->get('dictrict_id');
				$khachHangVip->ward_id = $request->get('ward_id');
				//$khachHangVip->cap_do = $request->get('cap_do');
				//$khachHangVip->nhom = $request->get('nhom');
				//$khachHangVip->san_pham_dich_vu_dang_dung = $request->get('san_pham_dich_vu_dang_dung');
				//$khachHangVip->nguon_khach_hang = $request->get('nguon_khach_hang');
				//$khachHangVip->nguoi_lien_he = $request->get('nguoi_lien_he');
				$khachHangVip->ghi_chu = $request->get('doanh_so');
				$khachHangVip->save();
				## insert don_hang_khach_hang_vip
				$donHang = DonHangKhachHangVipModel::findOrNew('');
				$donHang->ma_don_hang = "DHV-".strtoupper(uniqid());
				$donHang->id_user_tao = $userNew->user_id;
				$donHang->id_khach_hang_vip = $khachHangVip->id;
				//$donHang->id_khach_hoi_tham = $request->get('id_khach_hoi_tham');
				$donHang->trang_thai = 'Chờ duyệt';
				//$donHang->ma_khach_hang = $request->get('ma_khach_hang');
				$donHang->ten = $request->get('name');
				$donHang->phone_di_dong = $request->get('phone');
				$donHang->dia_chi = $request->get('dia_chi');
				$donHang->provice_id = $request->get('provice_id');
				$donHang->dictrict_id = $request->get('dictrict_id');
				$donHang->thanh_tien_sp_dv = (int)$request->get('ptotal')[0];
				$donHang->ward_id = $request->get('ward_id');
				//$donHang->name_facebook = $request->get('name_facebook');
				//$donHang->link_facebook = $request->get('link_facebook');
				//$donHang->link_comment_facebook = $request->get('link_comment_facebook');
				$donHang->id_kieu_don = 0;
				$donHang->id_kenh_ban = $request->get('id_kenh_ban');
				$donHang->id_store = $request->get('id_store');
				$donHang->thanh_tien = 0;
				$donHang->phi_van_chuyen = $request->get('phi_van_chuyen');
				$donHang->phi_thu_ho = $request->get('phi_thu_ho');
				$donHang->vat_phan_tram = $request->get('vat_phan_tram');
				$donHang->vat_thanh_tien = $request->get('vat_thanh_tien');
				$donHang->chiet_khau_phan_tram = $request->get('chiet_khau_phan_tram');
				$donHang->chiet_khau_thanh_tien = $request->get('chiet_khau_thanh_tien');
				//$donHang->phi_khac = $request->get('phi_khac');
				$donHang->tong_tien_don_hang = (int)$request->get('ptotal')[0];
				//$donHang->tien_khach_da_thanh_toan = $request->get('tien_khach_da_thanh_toan');
				//$donHang->tong_thanh_toan = $request->get('tong_thanh_toan');
				//$donHang->phi_chuyen_hoan = $request->get('phi_chuyen_hoan');
				//$donHang->thoi_gian_gui = $thoi_gian_gui;
				$donHang->ngay_ky_hop_dong = date('Y-m-d');
				//$donHang->ngay_su_dung = $request->get('ngay_su_dung');
				//$donHang->ngay_het_han = $request->get('ngay_het_han');
				//$donHang->thanh_tien_sp_dv = $request->get('thanh_tien_sp_dv');
				//$donHang->thanh_tien_khoan_thu = $request->get('thanh_tien_khoan_thu');
				$donHang->nguon_thu_ngoai = $request->get('doanh_so');
				//$donHang->tong_doanh_thu = $request->get('doanh_so');
				//$donHang->tong_doanh_thu_sau_chiet_khau = $request->get('doanh_so');
				//$donHang->tong_doanh_thu_sau_vat = $request->get('doanh_so');
				//$donHang->thanh_tien_khoan_chi = $request->get('thanh_tien_khoan_chi');
				//$donHang->phi_tra_hop_hong = $request->get('phi_tra_hop_hong');
				//$donHang->thanh_tien_tat_ca_khoan_chi = $request->get('thanh_tien_tat_ca_khoan_chi');
				//$donHang->loi_nhuan = $request->get('loi_nhuan');
				$donHang->save();
				$pcode = $request->get('pcode');
				$pnum = $request->get('pnum');
				$pprice = $request->get('pprice');
				$ptotal = $request->get('ptotal');
				foreach ($pcode as $key => $item) {
					$giaVon = 0;
					$product = WProductModel::where('product_code', $pcode[$key])->first();
					if ($product != null) {
						$giaVon = $product->product_price_input;
					}
					$donHangSanPham = DonHangKhachHangVipSanPhamModel::findOrNew(0);
					$donHangSanPham->id_don_hang = $donHang->id;
					$donHangSanPham->ma_san_pham = $pcode[$key];
					$donHangSanPham->so_luong = $pnum[$key];
					$donHangSanPham->gia_von = $giaVon;
					$donHangSanPham->tong_von = $giaVon * $pnum[$key];
					$donHangSanPham->gia_ban = $pprice[$key];
					$donHangSanPham->thanh_tien = $ptotal[$key];
					$donHangSanPham->save();
				}
				//Auth::attempt(array("phone"=>$user->phone,"password"=>$request->get('password')));
				return Response::json(['status' => 'true', 'message' => $user]);
				return Response::json(['status' => 'true']);
			}else{
				return Response::json(['status' => 'false', 'message' => 'Tài khoản đã tồn tại.']);
			}
		}
		return Response::json(['status' => 'false', 'message' => $validator->errors()->first()]);
	}
    public function gitPull()
    {
        $laravelPath = base_path();

        $output = shell_exec("cd $laravelPath && git pull");

        if (strpos($output, 'Already up to date.') !== false) {
            echo "Không có thay đổi mới!";
        } elseif (strpos($output, 'error:') !== false) {
            echo "Pull thất bại!";
        } else {
            echo "Pull thành công!";
        }
    }
}
