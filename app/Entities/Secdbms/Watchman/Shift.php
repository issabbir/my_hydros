<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'secdbms.wm_shift';
    protected $primaryKey = 'shift_id';
}
