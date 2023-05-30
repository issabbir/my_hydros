<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class WorkFlowStep extends Model
{
    protected $table = 'workflow_steps';
    protected $primaryKey = 'workflow_step_id';
}
