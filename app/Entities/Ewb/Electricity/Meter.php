<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Electricity;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    protected $table = 'e_meter';
    protected $primaryKey = 'meter_id';
}
