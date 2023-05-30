<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Water;

use Illuminate\Database\Eloquent\Model;

class BookingMst extends Model
{
    protected $table = 'w_booking_mst';
    protected $primaryKey = 'booking_mst_id';

    public function booking_details()
    {
        return $this->hasMany(BookingDtl::class, 'booking_mst_id');
    }

    public function requisition()
    {
        return $this->belongsTo(Requisition::class, 'req_id');
    }
}
