<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LZoneArea extends Model
{
    //
    protected $table = 'L_ZONEAREA';
    protected $primaryKey = "zonearea_id";
    public $timestamps = false;
}
