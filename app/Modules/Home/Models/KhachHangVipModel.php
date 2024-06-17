<?php 
namespace App\Modules\Home\Models;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Database\Eloquent\Model;
 
class KhachHangVipModel extends Model {

	protected $table = 'v_khach_hang_vip';
	protected $primaryKey = 'id';
	protected $fillable = [];

	public function all_don_hang()
	{
		return $this->hasMany(DonHangKhachHangVipModel::class, 'id_khach_hang_vip', 'id');
	}


}