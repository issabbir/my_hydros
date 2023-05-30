<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class WatchmanStatus extends Model
{
    protected $table = 'secdbms.wm_watchman_status';
    protected $primaryKey = 'status_id';
}
