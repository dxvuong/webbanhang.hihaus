<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'ma_gioi_thieu', 'fullname', 'phone', 'email', 'address', 'pay', 'note', 'products', 'status', 'code'
    );
}
