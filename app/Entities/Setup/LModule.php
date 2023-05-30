<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LModule extends Model
{
    //
    protected $table = 'L_MODULE';
    protected $primaryKey = "module_id";
    public $timestamps = false;
}
