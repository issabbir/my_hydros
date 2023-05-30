<?php

namespace App\Entities\Schedule;

use App\Entities\Setup\LMonth;
use App\Entities\Setup\Vehicle;
use Illuminate\Database\Eloquent\Model;

class BoatRosterApproval extends Model
{
    protected $table = 'BOAT_ROSTER_APPROVAL';
    protected $primaryKey = "boat_roster_approval_id";
    public $timestamps = false;
    protected $casts = [
        'approved_date' => 'date:Y-m-d',
        'schedule_date' => 'date:Y-m-d',
        // 'joined_at' => 'datetime:Y-m-d H:00',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function month()
    {
        return $this->belongsTo(LMonth::class, 'month_id');
    }
}
