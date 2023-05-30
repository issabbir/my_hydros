<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class AttempType extends Model
{
    protected $table = 'secdbms.wm_attemp_type';
    protected $primaryKey = 'attemp_type_id';
}
