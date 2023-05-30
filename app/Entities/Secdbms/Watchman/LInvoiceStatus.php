<?php

/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 5/13/20
 * Time: 12:30 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class LInvoiceStatus extends Model
{
    protected $table = 'secdbms.l_invoice_status';
    protected $primaryKey = 'invoice_status_id';
}
