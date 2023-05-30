<?php

namespace App\Entities\Schedule;

use App\Entities\Setup\LNotificationType;
use App\Entities\Schedule\ScheduleAssignment_2;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Team;
use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    protected $table = 'SCHEDULE_MASTER';
    protected $primaryKey = "schedule_master_id";
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
        return $this->belongsTo(LScheduleType::class, 'schedule_type_id');
    }

    public function scheduleAssignment_2()
    {
        return $this->belongsTo(ScheduleAssignment_2::class,'schedule_master_id');
    }
/*
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }*/
/*
    public function zonearea()
    {
        return $this->belongsTo(LZoneArea::class, 'zonearea_id');
    }


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }*/

    public function notification_type()
    {
        return $this->belongsTo(LNotificationType::class, 'notification_type_id');
    }
}
