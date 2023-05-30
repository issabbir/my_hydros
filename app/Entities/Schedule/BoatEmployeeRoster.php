<?php

namespace App\Entities\Schedule;

use App\Entities\Setup\Vehicle;
use Illuminate\Database\Eloquent\Model;

class BoatEmployeeRoster extends Model
{
    //

    protected $table = 'BOAT_EMPLOYEE_ROSTER';
    protected $primaryKey = "boat_employee_roster_id";
    public $timestamps = false;

    /*  SCHEDULE_DATE            DATE,
  SCHEDULE_FROM_TIME       DATE,
  SCHEDULE_TO_TIME         DATE,*/
    protected $casts = [
        'schedule_date' => 'date:Y-m-d',
       // 'schedule_to_date' => 'date:Y-m-d',
        // 'joined_at' => 'datetime:Y-m-d H:00',
    ];

    public function boat_employee()
    {
        return $this->belongsTo(BoatEmployee::class, 'boat_employee_id');
    }

}
