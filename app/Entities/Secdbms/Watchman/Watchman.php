<?php

/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/20/20
 * Time: 10:23 AM
 */

namespace App\Entities\Secdbms\Watchman;

use App\Entities\Admin\LBank;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\LExam;
use App\Entities\Admin\LExamBody;
use App\Entities\Admin\LInstitute;
use Illuminate\Database\Eloquent\Model;

class Watchman extends Model
{
    protected $table = 'secdbms.wm_watchman';
    protected $primaryKey = 'watchman_id';

    public function status()
    {
        return $this->belongsTo(WatchmanStatus::class, 'status_id');
    }

    public function wtc_status()
    {
        return $this->belongsTo(WatchmanStatus::class, 'status_id', 'status_id');
    }

    public function wtc_physical_cond()
    {
        return $this->belongsTo(PhysicalCondition::class, 'physical_condition_id', 'physical_condition_id');
    }

    public function l_exam()
    {
        return $this->belongsTo(LExam::class, 'highest_education_id', 'exam_id');
    }

    public function l_body()
    {
        return $this->belongsTo(LExamBody::class, 'exam_body_id', 'exam_body_id');
    }

    public function l_institute()
    {
        return $this->belongsTo(LInstitute::class, 'institute_id', 'institute_id');
    }

    public function eng_level()
    {
        return $this->belongsTo(EnglishLevel::class, 'english_level_id', 'english_level_id');
    }

    public function l_bank()
    {
        return $this->belongsTo(LBank::class, 'wm_bank_id', 'bank_id');
    }

    public function l_branch()
    {
        return $this->belongsTo(LBranch::class, 'wm_branch_id', 'branch_id');
    }

}
