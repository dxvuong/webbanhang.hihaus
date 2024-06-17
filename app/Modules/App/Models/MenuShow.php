<?php
namespace App\Modules\App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuShow extends Model
{
    protected $table = 'app_menu_show';
    protected $primaryKey = 'id';
    protected $fillable = [
        'menu_id',
        'menu_show_type_id',
        'menu_show_type',
    ];

    const THEORY_MENU_SHOW_TYPE = 1;
    const EXAM_MENU_SHOW_TYPE = 2;

}
