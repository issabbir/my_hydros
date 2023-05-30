<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 6/4/20
 * Time: 3:16 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class BookingDay extends Model
{
    protected $table = 'secdbms.wm_booking_day';
    protected $primaryKey = 'booking_day_id';
}