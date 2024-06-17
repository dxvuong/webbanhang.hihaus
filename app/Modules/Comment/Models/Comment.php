<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Comment\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'product_id', 'gender', 'name', 'phone', 'email', 'content', 'status', 'parent', 'like', 'order', 'blog_id', 'event_id'
    );
}
