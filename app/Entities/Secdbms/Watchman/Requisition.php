<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $table = 'secdbms.wm_requisition';
    protected $primaryKey = 'requisition_id';
}
