<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = array(
        'id', 'name', 'email', 'phone', 'login_name', 'password', 'birthday', 'avatar', 'address', 'provice_id', 'dictrict_id', 'ward_id', 'bank_account_number', 'bank_name', 'bank_account_name', 'bank_account_image'
    );
}