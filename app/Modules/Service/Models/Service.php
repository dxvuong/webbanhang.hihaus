<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model{
    protected $table = 'service';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'image', 'link', 'order', 'is_main', 'button'
    );
}


