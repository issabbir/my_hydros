<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LType extends Model
{
    //
    protected $table = 'L_TYPE';
    protected $primaryKey = "type_id";
    public $timestamps = false;

    protected $casts = [
        'from_date'  => 'date:Y-m-d',
        'to_date'  => 'date:Y-m-d',
        // 'joined_at' => 'datetime:Y-m-d H:00',
    ];
}
