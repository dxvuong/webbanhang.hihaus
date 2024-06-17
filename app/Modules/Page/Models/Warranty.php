<?php
namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model{
    protected $table = 'warranties';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'payer_name', 'company_name', 'address', 'payer_phone', 'car_plate', 'item_type', 'start_warranty', 'end_warranty', 'construction_agent', 'construction_person'
    );

    public function warrantyItems()
    {
        return $this->hasMany(WarrantyItem::class);
    }

    const HeatproofFilmCar = 1;
    const HeatproofFilmHouse = 2;

    const ArrayHeatproof = [
        self::HeatproofFilmCar => 'Phim cách nhiệt Ô tô',
        self::HeatproofFilmHouse => 'Phim cách nhiệt Nhà kính'
    ];
}
