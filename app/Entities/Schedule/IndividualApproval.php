<?php

namespace App\Entities\Schedule;

use App\Entities\Admin\LDesignation;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Setup\LVehicleType;
use App\Entities\Setup\Vehicle;
use Illuminate\Database\Eloquent\Model;

class IndividualApproval extends Model
{
    protected $table = 'ROASTER_INDIVIDUAL_APPV';
    protected $primaryKey = "ROASTER_MST_ID";
    public $timestamps = false;
}
