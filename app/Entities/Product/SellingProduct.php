<?php

namespace App\Entities\Product;

use App\Entities\Setup\LFileCategory;
use Illuminate\Database\Eloquent\Model;

class SellingProduct extends Model
{
    //

    protected $table = 'SELLING_PRODUCT';
    protected $primaryKey = "selling_product_id";
    public $timestamps = false;

    /*public function booking_details()
    {
        return $this->hasMany(BookingDtl::class, 'booking_mst_id');
    }*/

    public function file_category()
    {
        return $this->belongsTo(LFileCategory::class, 'file_category_id');
    }
}
