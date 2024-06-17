<?php
namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model{
    protected $table = 'landing_pages';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'url', 'order', 'status'
    );
}
