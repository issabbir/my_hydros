<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Water;

use Illuminate\Database\Eloquent\Model;

class InvoiceMst extends Model
{
    protected $table = 'w_invoice_mst';
    protected $primaryKey = 'invoice_mst_id';
}
