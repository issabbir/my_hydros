<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class ServiceEngineerInfo extends Model
{
    protected $table = 'ccms.service_engineer_info';
    protected $primaryKey = 'service_engineer_info_id';
    public $incrementing = false;
}
