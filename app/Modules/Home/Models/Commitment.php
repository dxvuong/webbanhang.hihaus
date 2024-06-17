<?php
namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class Commitment extends Model{
    protected $table = 'commitment';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'image', 'description', 'content', 'status', 'slug', 'order'
    );
}
