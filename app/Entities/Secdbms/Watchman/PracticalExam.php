<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class PracticalExam extends Model
{
    protected $table = 'secdbms.wm_practical_exam';
    protected $primaryKey = 'wm_practical_exam_id';
    protected $with  = ['practical_type'];

    public function practical_type()
    {
        return $this->belongsTo(PracticalType::class, 'wm_practical_type_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'instructor_emp_id');
    }
}
