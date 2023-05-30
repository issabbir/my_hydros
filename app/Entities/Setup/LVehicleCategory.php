<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LVehicleCategory extends Model
{
    //L_VECHILE_CATGEORY
    protected $table = 'L_VEHICLE_CATEGORY';
    protected $primaryKey = "vehicle_category_id";
    public $timestamps = false;
}
