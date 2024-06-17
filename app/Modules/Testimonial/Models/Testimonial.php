<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Testimonial\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'image', 'position', 'content', 'order', 'status', 'author'
    );
}

