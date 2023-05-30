<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class BookingMst extends Model
{
    protected $table = 'secdbms.wm_booking_mst';
    protected $primaryKey = 'booking_mst_id';
}
