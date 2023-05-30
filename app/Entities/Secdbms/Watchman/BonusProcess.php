<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class BonusProcess extends Model
{
    protected $table = 'secdbms.wm_bonus_process';
    protected $primaryKey = 'process_id';
}
