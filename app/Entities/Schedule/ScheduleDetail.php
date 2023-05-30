<?php

namespace App\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    //
    protected $table = 'SCHEDULE_DETAIL';
    protected $primaryKey = "schedule_detail_id";
    public $timestamps = false;
}
