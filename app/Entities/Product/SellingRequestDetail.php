<?php

namespace App\Entities\Product;

use App\Entities\File\FileInfo;
use Illuminate\Database\Eloquent\Model;

class SellingRequestDetail extends Model
{
    //
    protected $table = 'SELLING_REQUEST_DETAIL';
    protected $primaryKey = "selling_request_detail_id";
    public $timestamps = false;

    public function selling_request()
    {
        return $this->belongsTo(SellingRequest::class, 'selling_request_id');
    }

    public function file_info()
    {
        return $this->belongsTo(FileInfo::class, 'file_info_id');
    }
}
