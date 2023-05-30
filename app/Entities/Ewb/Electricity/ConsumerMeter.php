<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Electricity;

use Illuminate\Database\Eloquent\Model;

class ConsumerMeter extends Model
{
    protected $table = 'id';
    protected $primaryKey = 'consumer_id';
}
