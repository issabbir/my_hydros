<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Schedule\GadgeStationDtl;
use App\Entities\Schedule\GadgeStationList;
use App\Entities\Schedule\GadgeStationMst;
use App\Entities\Schedule\GadgeStationOffday;
use App\Entities\Schedule\GadgeStationShift;
use App\Entities\Secdbms\Watchman\WorkFlowStep;
use App\Entities\Security\GenNotifications;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class DredgingInspectionController extends Controller
{
    public function index(Request $request)
    {
        $designations = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION ORDER BY DESIGNATION_ID");
        $hydro_emp = DB::select("SELECT E.EMP_ID, E.EMP_CODE, E.EMP_NAME FROM PMIS.EMPLOYEE E WHERE E.DPT_DEPARTMENT_ID = 2 order by E.EMP_CODE ASC");

        return view('schedule.dredging-inspection-index', [
            'employee' => $hydro_emp,
            'designations' => $designations,
            'offdayList' => GadgeStationOffday::all(),
            'stationList' => GadgeStationList::all(),
            'workFlowStep' => WorkFlowStep::where('approval_workflow_id', '4')->get()
        ]);
    }


    public function post(Request $request)
    {


        $response = $this->api_ins($request);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.dredging-inspection-index');
    }

    private function api_ins(Request $request)
    {

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $ins_mst_id ="";

            $params_mst = [

                "P_INSPECTION_MST_ID" => [
                    "value" => &$ins_mst_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'P_NOTE' => $request->get('dreadging_note'),
                'P_INSERT_BY' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message
            ];

            DB::executeProcedure('HYDROAS.INSPECTION_MST_ENTRY',$params_mst);

            if ($params_mst['o_status_code'] != 1) {
                DB::rollBack();
                return $params_mst;
            }
            if ($request->get('tab_emp_id')) {
                foreach ($request->get('tab_emp_id') as $indx => $value) {

                    $inspection_date = isset($request->get('tab_dredging_from')[$indx]) ? date('Y-m-d', strtotime($request->get('tab_dredging_from')[$indx])) : '';
                    $tab_dredging_to = isset($request->get('tab_dredging_to')[$indx]) ? date('Y-m-d', strtotime($request->get('tab_dredging_to')[$indx])) : '';
                    $id = '';
                    $status_code = sprintf("%4000s", "");
                    $status_message = sprintf("%4000s", "");
                    $params = [
                        'P_INSPECTION_ID' => [
                            'value' => &$id,
                            'type' => \PDO::PARAM_INPUT_OUTPUT,
                            'length' => 255
                        ],
                        "P_INSPECTION_DATE" => $inspection_date,
//                        "P_ROSTER_TO_DATE" => $tab_dredging_to,
                        "P_SHIP_BOOKING_TIME" => $request->get('ship_booking_time')[$indx],
                        "P_SHIFT_BOOKING_FROM" => $request->get('shift_from_time')[$indx],
                        "P_SHIFT_BOOKING_TO" => $request->get('shift_to_time')[$indx],
                        "P_EMP_ID" => $request->get('tab_emp_id')[$indx],
//                        "P_OFFDAY_ID" => $request->get('tab_offday_id')[$indx],
                        "P_MOBILE_NO" => $request->get('tab_mobile_number')[$indx],
                        "P_REMARKS" => $request->get('tab_remrks')[$indx],
                        "P_INSPECTION_MST_ID"=> $params_mst['P_INSPECTION_MST_ID'],
                        "P_INSERT_BY" => auth()->id(),
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message
                    ];

                    DB::executeProcedure("HYDROAS.DREADGING_INSPECTION_ENTRY", $params);
                    if ($params['o_status_code'] != 1) {
                        DB::rollBack();
                        return $params;
                    }
                }
            }

        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


    public function dataTableList()
    {
        $queryResult = DB::select("SELECT D.*, E.EMP_NAME, DEP.DEPARTMENT_NAME
    FROM DREADGING_INSPECTION D
         LEFT JOIN DREADGING_INSPECTION_MST M
            ON M.INSPECTION_MST_ID = D.INSPECTION_MST_ID
         LEFT JOIN PMIS.EMPLOYEE E ON E.EMP_ID = D.EMP_ID
         LEFT JOIN PMIS.L_DEPARTMENT DEP ON DEP.DEPARTMENT_ID = D.DEPARTMENT_ID
ORDER BY D.INSPECTION_ID DESC");

        return datatables()->of($queryResult)

            ->addColumn('inspection_date', function ($query) {

                    return Carbon::parse($query->inspection_date)->format('d-M-Y');

            })
            ->addColumn('duty_time', function ($query) {

                    return $query->shift_booking_from.' - '.$query->shift_booking_to;

            })
            ->addColumn('action', function ($query) {
                return '<a title="Delete" href="' . route('schedule.dreadging_inspection_delete', [$query->inspection_id]) . '"><i class="bx bx-trash danger cursor-pointer"></i></a>';
            })

            ->addIndexColumn()
            ->make(true);
    }

    public function destroy($id){
        DB::table('DREADGING_INSPECTION')->where('inspection_id', $id)->delete();
        return redirect()->route('schedule.dredging-inspection-index');

    }




}
