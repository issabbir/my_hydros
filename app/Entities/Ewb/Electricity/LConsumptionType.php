<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Electricity;

use Illuminate\Database\Eloquent\Model;

class LConsumptionType extends Model
{
    protected $table = 'l_e_consumption_type';
    protected $primaryKey = 'consumption_type_id';
}
