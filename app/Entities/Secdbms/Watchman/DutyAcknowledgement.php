<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class DutyAcknowledgement extends Model
{
    protected $table = 'secdbms.wm_duty_ack';
    protected $primaryKey = 'ack_id';
}
