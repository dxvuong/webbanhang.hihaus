<?php
namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model{
    protected $table = 'header_settings';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'content', 'icon', 'col', 'type', 'order', 'status'
    );

}