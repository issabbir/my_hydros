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

class EnglishResult extends Model
{
    protected $table = 'secdbms.wm_english_result';
    protected $primaryKey = 'english_result_id';

    public function attemp_type()
    {
        return $this->belongsTo(AttempType::class, 'attemp_type_id');
    }

    public function exam_center()
    {
        return $this->belongsTo(ExamCenter::class, 'exam_center_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'comments_emp_id');
    }
}
