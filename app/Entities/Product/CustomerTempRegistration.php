<?php

namespace App\Entities\Product;

use Illuminate\Database\Eloquent\Model;

class CustomerTempRegistration extends Model
{
    //
    protected $table = 'CUSTOMER_TEMP_REGISTRATION';
    protected $primaryKey = "customer_temp_registration_id";
    public $timestamps = false;
    protected $hidden = ['user_password'];
}
