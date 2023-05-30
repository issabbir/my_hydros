<?php

namespace App\Entities\Schedule;

use App\Entities\Setup\LNotificationType;
use App\Entities\Schedule\ScheduleAssignment_2;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Team;
use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Model;

class Schedule_2 extends Model
{
    //
    protected $table = 'SCHEDULE_MASTER';
    protected $primaryKey = "schedule_master_id";
    protected $with=['schedule_type'];
    public $timestamps = false;

    protected $dates = [
        'schedule_from_date',
        'schedule_to_date'
    ];
    protected $casts = [
        'schedule_from_date' => 'date:Y-m-d',
        'schedule_to_date' => 'date:Y-m-d',
        // 'joined_at' => 'datetime:Y-m-d H:00',
    ];


    public function schedule_type()
    {
        return $this->belongsTo(LScheduleType::class, 'schedule_type_id')->select('schedule_type_id','schedule_type_name');
    }



}
