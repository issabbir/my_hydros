<?php

namespace App\Entities\Product;

use App\Entities\File\FileInfo;
use App\Entities\Setup\LFileCategory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'PRODUCT';
    protected $primaryKey = "product_id";
    public $timestamps = false;

    public function file_category()
    {
        return $this->belongsTo(LFileCategory::class, 'file_category_id');
    }

    /*public function product_detail()
    {
        return $this->hasMany(ProductDetail::class,'product_detail_id');
    }*/

    public function file_info()
    {
        return $this->belongsTo(FileInfo::class, 'file_info_id');
    }

}
