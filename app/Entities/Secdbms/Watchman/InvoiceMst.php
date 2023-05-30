<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class InvoiceMst extends Model
{
    protected $table = 'secdbms.wm_invoice_mst';
    protected $primaryKey = 'invoice_mst_id';

    public function agency_type()
    {
        return $this->belongsTo(LAgencyType::class, 'agency_type_id');
    }
}
