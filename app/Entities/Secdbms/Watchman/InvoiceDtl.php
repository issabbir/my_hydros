<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class InvoiceDtl extends Model
{
    protected $table = 'secdbms.wm_invoice_dtl';
    protected $primaryKey = 'invoice_dtl_id';

}
