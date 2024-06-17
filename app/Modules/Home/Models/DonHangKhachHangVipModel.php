<?php 
namespace App\Modules\Home\Models;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Database\Eloquent\Model;
 
class DonHangKhachHangVipModel extends Model {

	protected $table = 'v_don_hang_khach_hang_vip';
	protected $primaryKey = 'id';
	protected $fillable = [];


}