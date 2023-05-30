<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LNotificationType extends Model
{
    //
    protected $table = 'L_NOTIFICATION_TYPE';
    protected $primaryKey = "notification_type_id";
    public $timestamps = false;
}
