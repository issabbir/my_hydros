<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'secdbms.wm_training';
    protected $primaryKey = 'training_id';
}
