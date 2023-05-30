<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Water;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $table = 'w_requisition';
    protected $primaryKey = 'req_id';
}
