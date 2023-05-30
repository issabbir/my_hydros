<?php

namespace App\Entities\Product;

use App\Entities\File\FileInfo;
use App\Entities\Setup\LFileFormat;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    //

    protected $table = 'PRODUCT_DETAIL';
    protected $primaryKey = "product_detail_id";
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }


    public function file_info()
    {
        return $this->belongsTo(FileInfo::class, 'file_info_id');
    }

    public function file_format()
    {
        return $this->belongsTo(LFileFormat::class, 'file_format_id');
    }

}
