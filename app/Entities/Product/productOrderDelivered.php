<?php

namespace App\Entities\Product;

use App\Entities\Pmis\Employee\Employee;
use App\Entities\Setup\LFileCategory;
use Illuminate\Database\Eloquent\Model;

class productOrderDelivered extends Model
{
    //
    protected $table = 'PRODUCT_ORDER';
    protected $primaryKey = "product_order_id";
    public $timestamps = false;

    protected $casts = [
        'order_date'  => 'date:Y-m-d',
        'payment_completed_date'  => 'date:Y-m-d',
        // 'joined_at' => 'datetime:Y-m-d H:00',
    ];


}
