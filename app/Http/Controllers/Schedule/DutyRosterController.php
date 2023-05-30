<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Schedule\BoatEmployee;
use App\Entities\Schedule\Schedule_Mst;
use App\Entities\Setup\LMonth;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Team;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DutyRosterController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('schedule.duty-roster-index', [
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
            'months' => LMonth::with([])->get(),
            'month_id' => 1,
            'boat_employees' => null,
             'year_id' => date("Y")

        ]);

    }

    public function duty_roster_employee(Request $request)
    {
        $vehicle_id = $request->get('vehicle_id');
        $month_id = $request->get('month_id');
        $year_id = $request->get('year_id');

        return view('schedule.duty-roster-index', [

            'approval_status' => Schedule_Mst::where('active_yn', '=', YesNoFlag::YES)
                ->where('vehicle_id', '=', $vehicle_id)
                ->where('month_id', '=', $month_id)
                ->where('year_id', '=', $year_id)
                ->first(),
            'vehicles_status' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->first(),
            'vehicle_dtl' => Vehicle::with([])->where('vehicle_id', '=', $vehicle_id)->first(),
            'months_list' => LMonth::with([])->where('month_id', '=', $month_id)->first(),
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
            'boat_employees' => BoatEmployee::with('employee', 'designation')
                ->where('vehicle_id', '=', $vehicle_id)
                ->get(),
            'vehicle_id' => $vehicle_id,
            'month_id' => $month_id,
            'year_id' => $year_id,
            'months' => LMonth::with([])->get(),

        ]);

    }

    public function save(Request $request)
    {


        return response()->json($request->all());
    }


}
