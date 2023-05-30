<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LMonth extends Model
{
    //
    protected $table = 'L_MONTH';
    protected $primaryKey = "month_id";
    public $timestamps = false;


}
