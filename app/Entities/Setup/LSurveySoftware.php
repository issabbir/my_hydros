<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LSurveySoftware extends Model
{
    //
    protected $table = 'L_SURVEY_SOFTWARE';
    protected $primaryKey = "survey_software_id";
    public $timestamps = false;
}
