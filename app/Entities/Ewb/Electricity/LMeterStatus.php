<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Electricity;

use Illuminate\Database\Eloquent\Model;

class LMeterStatus extends Model
{
    protected $table = 'l_e_meter_status';
    protected $primaryKey = 'meter_status_id';
}
