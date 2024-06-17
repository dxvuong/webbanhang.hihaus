<?php
namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model{
    protected $table = 'brands';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'status', 'slug', 'logo', 'description', 'content', 'order'
    );
}
