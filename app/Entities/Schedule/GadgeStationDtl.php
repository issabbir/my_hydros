<?php

namespace App\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;

class GadgeStationDtl extends Model
{
    protected $table = 'GADGE_STATION_SCHEDULE_DTL';
    protected $primaryKey = "SCHEDULE_DTL_ID";
    public $timestamps = false;
}
