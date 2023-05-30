<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class LAgency extends Model
{
    protected $table = 'secdbms.l_agency';
    protected $primaryKey = 'agency_id';
    public $incrementing = false;
}
