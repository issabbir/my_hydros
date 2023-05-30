<?php

namespace App\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;

class GadgeStationOffday extends Model
{
    protected $table = 'L_GADGE_STATION_OFFDAY';
    protected $primaryKey = "OFFDAY_ID";
    public $timestamps = false;
}
