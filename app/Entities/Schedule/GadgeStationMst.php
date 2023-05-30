<?php

namespace App\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;

class GadgeStationMst extends Model
{
    protected $table = 'GADGE_STATION_SCHEDULE_MST';
    protected $primaryKey = "SCHEDULE_MST_ID";
    public $timestamps = false;
}
