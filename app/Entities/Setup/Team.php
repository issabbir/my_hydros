<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $table = 'TEAM';
    protected $primaryKey = "team_id";
    public $timestamps = false;

    public function team_type()
    {
        return $this->belongsTo(LTeamType::class, 'team_type_id');
    }
}
