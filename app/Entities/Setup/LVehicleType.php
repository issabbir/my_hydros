<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LVehicleType extends Model
{
    //
    protected $table = 'L_VEHICLE_TYPE';
    protected $primaryKey = "vehicle_type_id";
    public $timestamps = false;
}
