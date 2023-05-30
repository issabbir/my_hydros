<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Electricity;

use Illuminate\Database\Eloquent\Model;

class LSubStation extends Model
{
    protected $table = 'l_e_sub_station';
    protected $primaryKey = 'sub_station_id';
}
