<?php
namespace App\Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;

class UrlRedirect extends Model{
    protected $table = 'url_redirects';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'url_old', 'url_new', 'type', 'author'
    );
}
