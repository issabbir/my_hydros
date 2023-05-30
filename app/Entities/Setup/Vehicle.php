<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    protected $table = 'VEHICLE';
    protected $primaryKey = "vehicle_id";
    public $timestamps = false;

    public function vehicle_type()
    {
        return $this->belongsTo(LVehicleType::class, 'vehicle_type_id');
    }
    public function vehicle_category()
    {
        return $this->belongsTo(LVehicleCategory::class, 'vehicle_category_id');
    }
}
