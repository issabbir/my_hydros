<?php

namespace App\Entities\Schedule;

use App\Entities\Admin\LDesignation;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Setup\LVehicleType;
use App\Entities\Setup\Vehicle;
use Illuminate\Database\Eloquent\Model;

class BoatEmployee extends Model
{
    //

    protected $table = 'BOAT_EMPLOYEE';
    protected $primaryKey = "boat_employee_id";
    public $timestamps = false;

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }


    public function designation()
    {
        return $this->belongsTo(LDesignation::class, 'designation_id');
    }

}
