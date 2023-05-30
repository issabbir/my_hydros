<?php

namespace App\Entities\Product;

use App\Entities\Pmis\Employee\Employee;
use App\Entities\Setup\LFileCategory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product_order_detail(){
        return $this->hasMany('App\Entities\Product\ProductOrderDetail','product_order_id', 'product_order_id');
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'confirmed_by');
    }
    /*
        public function product_order_detail()
        {
            return $this->hasMany(ProductOrderDetail::class, 'product_order_detail_id');
        }*/
}
