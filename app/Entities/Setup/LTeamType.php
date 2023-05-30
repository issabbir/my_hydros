<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LTeamType extends Model
{
    //
    protected $table = 'L_TEAM_TYPE';
    protected $primaryKey = "team_type_id";
    public $timestamps = false;
}
