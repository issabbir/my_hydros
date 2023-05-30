<?php

namespace App\Entities\Product;

use App\Entities\Setup\LFileFormat;
use Illuminate\Database\Eloquent\Model;

class ProductOrderDetail extends Model
{
    //
    protected $table = 'PRODUCT_ORDER_detail';
    protected $primaryKey = "product_order_detail_id";
    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function product_detail()
    {
        return $this->belongsTo(ProductDetail::class,'product_detail_id');
    }

    public function file_format()
    {
        return $this->belongsTo(LFileFormat::class, 'file_format_id');
    }


    public function product_order_detail_file(){
        return $this->hasMany('App\Entities\Product\ProductOrderDetailFile','product_order_detail_id', 'product_order_detail_id');
    }
}
