<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class PracticalType extends Model
{
    protected $table = 'secdbms.wm_practical_type';
    protected $primaryKey = 'practical_type_id';
}
