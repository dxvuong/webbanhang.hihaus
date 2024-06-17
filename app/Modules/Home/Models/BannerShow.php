<?php
namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class BannerShow extends Model
{
    protected $table = 'banner_show';
    protected $primaryKey = 'id';
    protected $fillable = [
        'banner_id',
        'banner_show_type_id',
        'banner_show_type',
    ];

}
