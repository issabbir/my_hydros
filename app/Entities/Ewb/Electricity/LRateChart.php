<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Electricity;

use Illuminate\Database\Eloquent\Model;

class LRateChart extends Model
{
    protected $table = 'l_e_rate_chart';
    protected $primaryKey = 'rate_chart_id';
}
