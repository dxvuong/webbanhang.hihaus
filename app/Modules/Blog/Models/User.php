<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = array(
        'user_id', 'user_name', 'user_pass', 'user_full_name',
        'user_phone', 'user_mail', 'user_last_login',
        'user_last_ip', 'user_created', 'user_status', 'user_rid', 'user_image', 'session_id', 'stt',
        'nhan_su', 'ngay_sinh', 'phong_ban', 'vi_tri', 'thuong_tru', 'tam_tru', 'ngan_hang', 'so_tai_khoan', 'ten_tai_khoan'
    );
}