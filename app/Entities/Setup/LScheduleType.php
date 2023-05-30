<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LScheduleType extends Model
{
    //
    protected $table = 'L_SCHEDULE_TYPE';
    protected $primaryKey = "schedule_type_id";
    public $timestamps = false;
}
