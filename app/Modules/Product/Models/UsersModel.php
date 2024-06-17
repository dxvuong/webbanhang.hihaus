<?php 
namespace App\Modules\Product\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsersModel extends Authenticatable {

	protected $table = 'user';
	protected $primaryKey = 'user_id';
	protected $fillable = [];
	protected $casts = [
		'child_user_ids' => 'array'
	];
	public function all_child()
	{
		return $this->hasMany(UserModel::class, 'ma_gioi_thieu', 'ma_gioi_thieu');
	}

}