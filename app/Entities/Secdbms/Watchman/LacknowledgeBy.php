<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class LacknowledgeBy extends Model
{
    protected $table = 'secdbms.l_ack_by';
    protected $primaryKey = 'ack_by_id';
}
