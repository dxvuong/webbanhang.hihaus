<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'email', 'phone', 'link', 'subject', 'content', 'status'
    );
}


