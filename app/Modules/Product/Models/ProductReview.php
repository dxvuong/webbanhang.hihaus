<?php
namespace App\Modules\Product\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model{
    protected $table = 'product_reviews';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'product_id', 'user_id', 'star', 'images', 'content'
    );

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
