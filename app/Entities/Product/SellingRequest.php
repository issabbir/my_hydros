<?php

namespace App\Entities\Product;

use App\Entities\Setup\LFileFormat;
use Illuminate\Database\Eloquent\Model;

class SellingRequest extends Model
{
    //

    protected $table = 'SELLING_REQUEST';
    protected $primaryKey = "selling_request_id";
    public $timestamps = false;

    public function file_format()
    {
        return $this->belongsTo(LFileFormat::class, 'file_format_id');
    }

    public function selling_product()
    {
        return $this->belongsTo(SellingProduct::class, 'selling_product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function selling_request_details()
    {
        return $this->hasMany(SellingRequestDetail::class, 'selling_request_detail_id');
    }
}
