<?php

namespace App\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;

class GadgeStationShift extends Model
{
    protected $table = 'L_GADGE_STATION_SHIFT';
    protected $primaryKey = "SHIFT_ID";
    public $timestamps = false;
}
