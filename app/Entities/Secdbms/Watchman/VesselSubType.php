<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class VesselSubType extends Model
{
    protected $table = 'secdbms.wm_vessel_sub_type';
    protected $primaryKey = 'vessel_sub_type_id';
}
