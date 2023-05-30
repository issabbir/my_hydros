<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Electricity;

use Illuminate\Database\Eloquent\Model;

class LMeterType extends Model
{
    protected $table = 'l_e_meter_type';
    protected $primaryKey = 'meter_type_id';
}
