<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class SalaryProcess extends Model
{
    protected $table = 'secdbms.wm_salary_process';
    protected $primaryKey = 'process_id';
}
