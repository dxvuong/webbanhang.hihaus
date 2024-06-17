<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model{
    protected $table = 'event';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'image', 'description', 'content', 'category', 'order', 'status', 'slug', 'author', 'menu', 'event'
    );
}


