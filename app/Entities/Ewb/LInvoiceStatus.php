<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb;

use Illuminate\Database\Eloquent\Model;

class LInvoiceStatus extends Model
{
    protected $table = 'l_invoice_status';
    protected $primaryKey = 'invoice_status_id';
}
