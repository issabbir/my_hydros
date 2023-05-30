<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class BookingDtl extends Model
{
    protected $table = 'secdbms.wm_booking_dtl';
    protected $primaryKey = 'booking_dtl_id';
}
