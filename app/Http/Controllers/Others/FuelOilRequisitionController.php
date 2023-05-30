<?php

namespace App\Http\Controllers\Others;

use App\Entities\Others\VehicleRequisition;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Team;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FuelOilRequisitionController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get();

        return view('others.fuel-oil-requisition-index', [
            'vehicles' => $vehicles,
        ]);
    }


    public function post(Request $request)
    {
        $vehicle_id = $request->get('vehicle_id');

        $vehicle = Vehicle::with([])->find($vehicle_id);

        $message = "Vehicle fuel consumption list fetched successfully";
        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);


        $vehicles = Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get();

        $vehicle_requisitions = VehicleRequisition::with("requisition_emp","approved_emp","vehicle")
           // ->where('vehicle_id', '=', $vehicle_id)
            ->get();

        return view('others.fuel-oil-requisition-index', [
            'vehicle' => $vehicle,
            'vehicles' => $vehicles,
            'vehicle_requisitions' =>$vehicle_requisitions
        ]);
    }
}
