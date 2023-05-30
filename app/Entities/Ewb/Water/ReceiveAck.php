<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Water;

use Illuminate\Database\Eloquent\Model;

class ReceiveAck extends Model
{
    protected $table = 'w_receive_ack';
    protected $primaryKey = 'ack_id';
}
