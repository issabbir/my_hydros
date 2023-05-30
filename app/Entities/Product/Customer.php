<?php

namespace App\Entities\Product;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{
    //
    protected $table = 'CUSTOMER';
    protected $primaryKey = "customer_id";
    public $timestamps = false;
    //'customer_id',
    protected $hidden = ['user_password'];
}
