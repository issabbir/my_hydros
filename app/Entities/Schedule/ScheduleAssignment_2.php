<?php

namespace App\Entities\Schedule;

use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Team;
use App\Entities\Setup\Vehicle;
use Illuminate\Database\Eloquent\Model;

class ScheduleAssignment_2 extends Model
{
    //

    protected $table = 'SCHEDULE_ASSIGNMENT';
    protected $primaryKey = "schedule_assignment_id";
    public $timestamps = false;

    protected $dates = [
        'schedule_from_time',
        'schedule_to_time',
        'schedule_date',
    ];

    protected $casts = [
        'schedule_from_time' => 'date:H:i',
        'schedule_to_time' => 'date:H:i',
        'schedule_date' => 'date:Y-m-d',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    public function schedule2()
    {
        return $this->belongsTo(Schedule_2::class, 'schedule_master_id');
    }
}
