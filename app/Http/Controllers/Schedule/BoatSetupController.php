<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Schedule\GadgeStationDtl;
use App\Entities\Schedule\GadgeStationList;
use App\Entities\Schedule\GadgeStationMst;
use App\Entities\Schedule\GadgeStationOffday;
use App\Entities\Schedule\GadgeStationShift;
use App\Entities\Setup\LVehicleCategory;
use App\Entities\Setup\LVehicleType;
use App\Entities\Setup\Vehicle;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class BoatSetupController extends Controller
{
    public function index()
    {
        return view('schedule.boat-setup', [
            'boatType' => LVehicleType::all(),
            'boatCategory' => LVehicleCategory::all()
        ]);
    }

    public function dataTableList()
    {
        $queryResult = DB::select("SELECT v.vehicle_id,
         v.vehicle_name,
         v.vehicle_name_bn,
         v.description,
         v.engine_capacity,
         v.origin,
         v.model_year,
         v.fuel_type,
         vc.category_name,
         vt.type_name
    FROM vehicle v
         LEFT JOIN l_vehicle_category vc
             ON (vc.vehicle_category_id = v.vehicle_catgeory_id)
         LEFT JOIN l_vehicle_type vt
             ON (vt.vehicle_type_id = v.vehicle_type_id)
ORDER BY v.insert_time DESC");
        return datatables()->of($queryResult)
            ->addColumn('action', function ($query) {
                $actionBtn = '<a title="Edit" href="' . route('schedule.boat-setup-edit', [$query->vehicle_id]) . '"><i class="bx bx-edit cursor-pointer"></i></a>';
                return $actionBtn;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function edit(Request $request, $id)
    {
        $vInfo = Vehicle::select('*')
            ->where('vehicle_id', '=', $id)
            ->first();

        return view('schedule.boat-setup', [
            'boatType' => LVehicleType::all(),
            'boatCategory' => LVehicleCategory::all(),
            'vInfo' => $vInfo
        ]);
    }

    public function post(Request $request)
    {
        $response = $this->api_ins_upd($request);
        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.boat-setup-index');
    }

    public function update(Request $request, $id)
    {//dd($request);
        $response = $this->api_ins_upd($request, $id);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.boat-setup-index');
    }

    private function api_ins_upd(Request $request)
    {//dd($request);
        $postData = $request->post();
        if(isset($postData['vehicle_id'])){
            $vehicle_id = $postData['vehicle_id'];
        }else{
            $vehicle_id = '';
        }
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $vehicle_id_out = sprintf("%4000s", "");

            $params = [
                'P_VEHICLE_ID' => $vehicle_id,
                'P_VEHICLE_TYPE_ID' => $postData['vehicle_type_id'],
                'P_VEHICLE_CATGEORY_ID' => $postData['vehicle_category_id'],
                'P_VEHICLE_NAME' => $postData['vehicle_name'],
                'P_VEHICLE_NAME_BN' => $postData['vehicle_name_bn'],
                'P_DESCRIPTION' => $postData['description'],
                'P_ENGINE_CAPACITY' => $postData['engine_capacity'],
                'P_ORIGIN' => $postData['origin'],
                'P_MODEL_YEAR' => $postData['model_year'],
                'P_FUEL_TYPE' => $postData['fuel_type'],
                'P_INSERT_BY' => auth()->id(),
                'O_VEHICLE_ID' => &$vehicle_id_out,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            DB::executeProcedure('HYDROAS.VEHICLE_INS_UPD', $params);

            if ($params['o_status_code'] != 1) {
                DB::rollBack();
                return $params;
            }

        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

}
