<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class VesselType extends Model
{
    protected $table = 'secdbms.wm_vessel_type';
    protected $primaryKey = 'vessel_type_id';
}
