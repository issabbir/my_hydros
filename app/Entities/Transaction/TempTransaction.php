<?php

namespace App\Entities\Transaction;

use Illuminate\Database\Eloquent\Model;

class TempTransaction extends Model
{
    //
    protected $table = 'TEMP_TRANSACTION';
    protected $primaryKey = "CUSTOMER_ID";
    public $timestamps = false;
}
