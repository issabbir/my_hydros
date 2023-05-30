<?php

namespace App\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;

class GadgeStationList extends Model
{
    protected $table = 'L_GADGE_STATION';
    protected $primaryKey = "STATION_ID";
    public $timestamps = false;
}
