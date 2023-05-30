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

class ReaderRosterApprovalController extends Controller
{
    public function index(Request $request)
    {
        $designations = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION ORDER BY DESIGNATION_ID");
        $hydro_emp = DB::select("SELECT EMP_ID,EMP_NAME FROM V_EMPLOYEE");
        return view('schedule.reader-approval-index', [
            'employee' => $hydro_emp,
            'offdayList' => GadgeStationOffday::all(),
            'shiftList' => GadgeStationShift::all(),
            'designations' => $designations,
            'stationList' => GadgeStationList::all(),
            'workFlowStep' => WorkFlowStep::where('approval_workflow_id', '4')->get()
        ]);
    }

    public function dataTableList()
    {
        $queryResult = DB::select("SELECT GSSM.*, GS.STATION_NAME FROM GADGE_STATION_SCHEDULE_MST GSSM
LEFT JOIN L_GADGE_STATION GS ON (GS.STATION_ID = GSSM.STATION_ID)
ORDER BY GSSM.INSERT_DATE DESC");
        return datatables()->of($queryResult)
            ->addColumn('insert_date', function ($query) {
                if($query->insert_date!=null){
                    return Carbon::parse($query->insert_date)->format('d-m-Y');
                }else{
                    return '--';
                }

            })
            ->addColumn('approve_date', function ($query) {
                if($query->update_date!=null){
                    return Carbon::parse($query->update_date)->format('d-m-Y');
                }else{
                    $html = <<<HTML
<span class="badge badge-light">APPROVAL PENDING</span>
HTML;
                    return $html;
                    //return 'Approval In Progress.';
                }

            })
            ->addColumn('status', function ($query) {
                if($query->active_yn == 'Y') {
                    return 'Active';
                } else {
                    return 'In-Active';
                }
            })
            ->addColumn('action', function ($query) {
                $wf_status = DB::select("select * from WORKFLOW_PROCESS where WORKFLOW_STEP_ID = 39 and WORKFLOW_OBJECT_ID = ".$query->schedule_mst_id);
                if(count($wf_status)>0){
                    $html = <<<HTML
<span class="badge badge-success">ROSTER APPROVED</span>
HTML;
                    return $html;
                }else{
                    $sql = "SELECT WS.WORKFLOW AS STEP, WS.WORKFLOW_KEY FROM WORKFLOW_PROCESS WP
LEFT JOIN WORKFLOW_STEPS WS ON WS.WORKFLOW_STEP_ID = WP.WORKFLOW_STEP_ID
WHERE WP.WORKFLOW_OBJECT_ID = :WORKFLOW_OBJECT_ID
ORDER BY WP.WORKFLOW_PROCESS_ID DESC
FETCH FIRST 1 ROW ONLY";
                    $mst_data = DB::selectOne($sql,['WORKFLOW_OBJECT_ID' =>  $query->schedule_mst_id]);

                    if($mst_data){
                        $role_key = json_decode(Auth::user()->roles->pluck('role_key'));
                        if (in_array($mst_data->workflow_key, $role_key)){
                            $actionBtn = '<a data-pilotageid="' . $query->schedule_mst_id . '" class="text-primary removeData"><i class="bx bx-trash cursor-pointer"></i></a> || <a href="javascript:void(0)" class="show-receive-modal editButton" title="Approve"><i class="bx bx-check-circle cursor-pointer"></i></a>';
                            return $actionBtn;
                        }else{
                            $html = <<<HTML
<span class="badge badge-warning">$mst_data->step</span>
HTML;
                            return $html;
                        }
                    }else{
                        //$actionBtn = '<a title="Edit" href="' . route('schedule.gadge-reader-roster-edit', [$query->schedule_mst_id]) . '"><i class="bx bx-edit cursor-pointer"></i></a>';
                        $actionBtn = '<a data-pilotageid="' . $query->schedule_mst_id . '" class="text-primary removeData"><i class="bx bx-trash cursor-pointer"></i></a>||<a href="javascript:void(0)" class="show-receive-modal editButton" title="Approve"><i class="bx bx-check-circle cursor-pointer"></i></a> ';
                        return $actionBtn;
                    }
                }
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function employee_by_designation(Request $request){
        //dd($request->all());
        $designation_id = $request->get('id');
        $emp_id = $request->get('emp_id');
        $employees = DB::select("SELECT EMP_ID,EMP_NAME FROM V_EMPLOYEE WHERE DESIGNATION_ID = ".$designation_id);

        $msg = '<option value="">Select One</option>';
        foreach ($employees as $data){
            //$msg .= '<option value="'.$data->emp_id.'" '.($data->emp_name == $emp_id ? 'selected' : "" ).'>'.$data->emp_name.'</option>';
            $msg .= '<option value="'.$data->emp_id.'" >'.$data->emp_name.'</option>';
        }
        return $msg;
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

        return redirect()->route('schedule.gadge-reader-roster-index');
    }

    private function api_ins(Request $request)
    {//dd($request);
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $schedule_mst_id = sprintf("%4000s", "");

            $params = [
                'P_STATION_ID' => $request->get('station_id')[0],
                'P_INSERT_BY' => auth()->id(),
                'O_SCHEDULE_MST_ID' => &$schedule_mst_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            DB::executeProcedure('HYDROAS.GADGE_STATION_MST_INSERT', $params);

            if ($params['o_status_code'] != 1) {
                DB::rollBack();
                return $params;
            }
            if ($request->get('tab_emp_id')) {
                foreach ($request->get('tab_emp_id') as $indx => $value) {

                    $roster_from_date = isset($request->get('tab_roster_from')[$indx]) ? date('Y-m-d', strtotime($request->get('tab_roster_from')[$indx])) : '';
                    $roster_to_date = isset($request->get('tab_roster_to')[$indx]) ? date('Y-m-d', strtotime($request->get('tab_roster_to')[$indx])) : '';

                    $status_code = sprintf("%4000s", "");
                    $status_message = sprintf("%4000s", "");
                    $params_dtl = [
                        "P_SCHEDULE_DTL_ID" => $request->get('schedule_dtl_id')[$indx],
                        "P_SCHEDULE_MST_ID" => $params['O_SCHEDULE_MST_ID'],
                        "P_STATION_ID" => $request->get('station_id')[$indx],
                        "P_ROSTER_FROM_DATE" => $roster_from_date,
                        "P_ROSTER_TO_DATE" => $roster_to_date,
                        "P_DESIGNATION_ID" => null,//$request->get('tab_designation_id')[$indx],
                        "P_EMP_ID" => $request->get('tab_emp_id')[$indx],
                        "P_SHIFT_ID" => $request->get('tab_shift_id')[$indx],
                        "P_OFFDAY_ID" => $request->get('tab_offday_id')[$indx],
                        "P_MOBILE_NO" => $request->get('tab_mobile_number')[$indx],
                        "P_REMARKS" => $request->get('tab_remrks')[$indx],
                        "P_INSERT_BY" => auth()->id(),
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message
                    ];

                    DB::executeProcedure("HYDROAS.GADGE_STATION_DTL_INSERT", $params_dtl);
                    if ($params_dtl['o_status_code'] != 1) {
                        DB::rollBack();
                        return $params_dtl;
                    }
                }
            }

        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function edit(Request $request, $id)
    {
        $hydro_emp = DB::select("SELECT EMP_ID,EMP_NAME FROM V_EMPLOYEE");
        $scheduleMaster = GadgeStationMst::select('*')
            ->where('schedule_mst_id', '=', $id)
            ->first();

        $scheduleDetail = GadgeStationDtl::where('schedule_mst_id', '=', $id)->get();

        $designations = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION ORDER BY DESIGNATION_ID");

        /*$desWiseEmp = [];
        if($insertedData && $insertedData->department_id) {
            $desWiseEmp = LSanctionedPost::with(['des_info'])
                ->where('department_id', $insertedData->department_id)->get();
        }*/
        $tab_employees = DB::select("SELECT EMP_ID,EMP_NAME FROM V_EMPLOYEE");

        return view('schedule.gadge-reader-index', [
            'employee' => $hydro_emp,
            'offdayList' => GadgeStationOffday::all(),
            'shiftList' => GadgeStationShift::all(),
            'designations' => $designations,
            'scheduleMaster' => $scheduleMaster,
            'scheduleDetail' => $scheduleDetail,
            'tab_employees' => $tab_employees,
            'stationList' => GadgeStationList::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $response = $this->api_upd($request, $id);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.gadge-reader-roster-index');
    }

    private function api_upd(Request $request)
    {//dd($request);
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $schedule_mst_id = sprintf("%4000s", "");

            $params = [
                'P_SCHEDULE_MST_ID' => $request->get('schedule_mst_id')[0],
                'P_STATION_ID' => $request->get('station_id')[0],
                'P_INSERT_BY' => auth()->id(),
                'O_SCHEDULE_MST_ID' => &$schedule_mst_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            DB::executeProcedure('HYDROAS.GADGE_STATION_MST_UPDT', $params);

            if ($params['o_status_code'] != 1) {
                DB::rollBack();
                return $params;
            }
            if ($request->get('tab_emp_id')) {
                foreach ($request->get('tab_emp_id') as $indx => $value) {

                    $roster_from_date = isset($request->get('tab_roster_from')[$indx]) ? date('Y-m-d', strtotime($request->get('tab_roster_from')[$indx])) : '';
                    $roster_to_date = isset($request->get('tab_roster_to')[$indx]) ? date('Y-m-d', strtotime($request->get('tab_roster_to')[$indx])) : '';

                    $status_code = sprintf("%4000s", "");
                    $status_message = sprintf("%4000s", "");
                    $params_dtl = [
                        "P_SCHEDULE_DTL_ID" => $request->get('schedule_dtl_id')[$indx],
                        "P_SCHEDULE_MST_ID" => $params['O_SCHEDULE_MST_ID'],
                        "P_STATION_ID" => $request->get('station_id')[0],
                        "P_ROSTER_FROM_DATE" => $roster_from_date,
                        "P_ROSTER_TO_DATE" => $roster_to_date,
                        "P_DESIGNATION_ID" => null,//$request->get('tab_designation_id')[$indx],
                        "P_EMP_ID" => $request->get('tab_emp_id')[$indx],
                        "P_SHIFT_ID" => $request->get('tab_shift_id')[$indx],
                        "P_OFFDAY_ID" => $request->get('tab_offday_id')[$indx],
                        "P_MOBILE_NO" => $request->get('tab_mobile_number')[$indx],
                        "P_REMARKS" => $request->get('tab_remrks')[$indx],
                        "P_INSERT_BY" => auth()->id(),
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message
                    ];

                    DB::executeProcedure("HYDROAS.GADGE_STATION_DTL_INSERT", $params_dtl);
                    if ($params_dtl['o_status_code'] != 1) {
                        DB::rollBack();
                        return $params_dtl;
                    }
                }
            }

        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function removeDtlData(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->get('schedule_dtl_id') as $indx => $value) {
                GadgeStationDtl::where('schedule_dtl_id', $request->get("schedule_dtl_id")[$indx])->delete();
            }
            DB::commit();
            return '1';
        } catch (\Exception $e) {
            DB::rollBack();
            return '0';
        }

    }

    public function getDtlData($schedule_mst_id)
    {
        $dtl_data = [];
        $mst_data = [];

        $sql1 = "select sm.SCHEDULE_MST_ID,sm.STATION_ID,gs.STATION_NAME from HYDROAS.GADGE_STATION_SCHEDULE_MST sm
left join HYDROAS.L_GADGE_STATION gs on gs.STATION_ID = sm.STATION_ID
where sm.SCHEDULE_MST_ID = :SCHEDULE_MST_ID";

        $mst_data = DB::selectOne($sql1,['SCHEDULE_MST_ID' =>  $schedule_mst_id]);

        $sql = "SELECT sd.SCHEDULE_MST_ID,
       sd.STATION_ID,
       sd.SCHEDULE_DTL_ID,
       sd.ROSTER_FROM_DATE,
       sd.ROSTER_TO_DATE,
       sd.SHIFT_ID,
       sd.OFFDAY_ID,
       gs.STATION_NAME,
          TO_CHAR (shf.SHIFT_FROM_TIME, 'hh12:mi:ss AM')
       || '~'
       || TO_CHAR (shf.SHIFT_TO_TIME, 'hh12:mi:ss AM')    SHIFT,
       offd.OFFDAY_NAME,
       sd.EMP_ID,
       emp.EMP_NAME,
       sd.MOBILE_NO,
       sd.REMARKS
  FROM HYDROAS.GADGE_STATION_SCHEDULE_DTL  sd
       LEFT JOIN HYDROAS.GADGE_STATION_SCHEDULE_MST sm
           ON sm.SCHEDULE_MST_ID = sd.SCHEDULE_MST_ID
       LEFT JOIN HYDROAS.L_GADGE_STATION gs ON gs.STATION_ID = sd.STATION_ID
       LEFT JOIN HYDROAS.L_GADGE_STATION_OFFDAY offd
           ON offd.OFFDAY_ID = sd.OFFDAY_ID
       LEFT JOIN HYDROAS.L_GADGE_STATION_SHIFT shf
           ON shf.SHIFT_ID = sd.SHIFT_ID
           LEFT JOIN PMIS.EMPLOYEE emp
           ON emp.EMP_ID = sd.EMP_ID
 WHERE sm.SCHEDULE_MST_ID = :SCHEDULE_MST_ID";

        $dtl_data = DB::select($sql,['SCHEDULE_MST_ID' =>  $schedule_mst_id]);

        return  response(
            [
                'mst_data' => $mst_data,
                'dtl_data' => $dtl_data,
            ]
        );
    }

    public function removeData(Request $request)
    {
        try {
            DB::beginTransaction();
            GadgeStationDtl::where('schedule_mst_id', $request->get("row_id"))->delete();
            GadgeStationMst::where('schedule_mst_id', $request->get("row_id"))->delete();
            DB::commit();
            return '1';
        } catch (\Exception $e) {
            DB::rollBack();
            return '0';
        }

    }
}
