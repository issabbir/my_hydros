<?php

namespace App\Entities\Others;

use App\Entities\Pmis\Employee\Employee;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\Vehicle;
use Illuminate\Database\Eloquent\Model;

/*
 CREATE TABLE HYDROAS.
(
  MASTER_NAME             VARCHAR2(200 BYTE),
  REQUISITION_BY          VARCHAR2(500 BYTE),
  REQUISITION_DATE        DATE,
  BOAT_MILLAGE            NUMBER,
  RUNNING_MILLAGE         NUMBER,
  REQUESTED_FUEL_QTY      NUMBER,
  DELIVERED_FUEL_QTY      NUMBER,
  APPROVED_BY             VARCHAR2(200 BYTE),
  APPROVED_DATE           DATE,
  VEHICLE_ID              NUMBER
)
 */
class VehicleRequisition extends Model
{

    protected $table = 'VEHICLE_REQUISITION';
    protected $primaryKey = "vehicle_requisition_id";
    public $timestamps = false;

    protected $casts = [
        'requisition_date' => 'date:Y-m-d',
        'approved_date' => 'date:Y-m-d',
    ];


    public function requisition_emp()
    {
        return $this->belongsTo(Employee::class, 'requisition_by');
    }


    public function approved_emp()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
