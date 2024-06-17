<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model{
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'fullname', 'phone', 'email', 'link', 'week', 'hour', 'status'
    );
}


