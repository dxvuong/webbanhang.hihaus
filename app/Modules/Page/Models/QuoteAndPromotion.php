<?php
namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteAndPromotion extends Model{
    protected $table = 'quote_and_promotion';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'phone', 'product_id', 'content', 'pay', 'status', 'parameters'
    );

    const INSTALLMENT = 1;
    const PAY_IN_FULL = 2;
}
