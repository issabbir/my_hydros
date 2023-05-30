<?php

namespace App\Entities\Setup;

use App\Entities\Admin\LDesignation;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class TeamEmployee extends Model
{
    //
    protected $table = 'TEAM_EMPLOYEE';
    protected $primaryKey = "team_employee_id";
    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
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
