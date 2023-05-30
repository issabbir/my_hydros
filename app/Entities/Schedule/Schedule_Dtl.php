<?php

namespace App\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;

class Schedule_Dtl extends Model
{
    protected $table = 'SCHEDULE_APPROVAL_DTL';
    protected $primaryKey = "SCHEDULE_DTL_ID";
    public $timestamps = false;
}
