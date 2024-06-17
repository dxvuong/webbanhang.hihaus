<?php
namespace App\Modules\Page\Models;

use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

class WarrantyItem extends Model{
    protected $table = 'warranty_items';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'warranty_id', 'product_id', 'product_name', 'model', 'quantity', 'seri', 'warranty', 'price', 'total_price', 'comment'
    );

}
