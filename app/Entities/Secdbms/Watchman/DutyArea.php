<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class DutyArea extends Model
{
    protected $table = 'secdbms.wm_duty_area';
    protected $primaryKey = 'duty_area_id';
}
