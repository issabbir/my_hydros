<?php

namespace App\Entities\Product;

use App\Entities\File\FileInfo;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Setup\LFileCategory;
use Illuminate\Database\Eloquent\Model;

class ProductOrderDetailFile extends Model
{
    //
    protected $table = 'PRODUCT_ORDER_DETAIL_FILE';
    protected $primaryKey = "product_order_detail_file_id";
    public $timestamps = false;


    public function file_info()
    {
        return $this->belongsTo(FileInfo::class, 'file_info_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'uploaded_by');
    }

}
