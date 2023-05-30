<?php

namespace App\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;

class Schedule_Mst extends Model
{
    protected $table = 'SCHEDULE_APPROVAL_MST';
    protected $primaryKey = "SCHEDULE_MST_ID";
    public $timestamps = false;
}
