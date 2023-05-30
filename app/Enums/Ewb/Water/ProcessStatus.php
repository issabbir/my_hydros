<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 7/2/20
 * Time: 2:14 PM
 */

namespace App\Enums\Ewb\Water;


class ProcessStatus
{
    public const REQUISITION_RECEIVED = 1;
    public const BOOKING_CONFIRMED = 2;
    public const ASSIGNMENT_CONFIRMED = 3;
    public const WATER_DELIVERED = 4;
}