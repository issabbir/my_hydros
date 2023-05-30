<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Pmis\Employee\Employee;
use App\Entities\Schedule\BoatEmployee;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Team;
use App\Entities\Setup\TeamEmployee;
use App\Entities\Setup\Vehicle;
use App\Entities\Setup\VEmployee;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoatEmployeeController extends Controller
{
    public function boat_employee_get(Request $request)
    {
        $boat_employee_id = $request->get('boat_employee_id');

        $response = array();
        $response['o_status_code'] = 1;
        $response['o_status_message'] = 'Data get successfully';

        $response['boat_employee'] = BoatEmployee::with(['employee'])->find($boat_employee_id);

        return response()->json($response);
    }

    public function index(Request $request)
    {
        $designations = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION ORDER BY DESIGNATION_ID");
        $defaultDesignation = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION WHERE DESIGNATION_ID IN (517, 35, 176, 114, 157) ORDER BY DESIGNATION_ID");
        $data = [];
        foreach ($defaultDesignation as $d) {
            $did = $d->designation_id;
            $employee = DB::select('select emp_id,emp_name,emp_code from v_employee e where e.designation_id =:did', ['did' => $did]);
            $data[$d->designation_id] = $employee;
        }

        return view('schedule.boat-employee-index', [
            'boat_employees' => null,
            'boat_employee' => null,
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
            'designations' => $designations,
            'employees' => null,
            'defaultData' => $data,
        ]);
    }

    public function dataTableList(Request $request)
    {
        $vehicle_id = $request->get('id');

        /*$query = $this->base_query() . " WHERE TE.VEHICLE_ID = " . $vehicle_id . " ORDER BY TE.boat_employee_id ASC";
        $queryResult = DB::select($query);*/
        $query = "SELECT ROWNUM sl, a.*
  FROM (  SELECT TE.boat_employee_id,
(case when te.active_yn = 'Y' then 'Yes' else 'No' end) as active_yn,
(case when te.team_leader_yn = 'Y' then 'Yes' else 'No' end) as team_leader_yn,
T.VEHICLE_NAME ,TE.MOBILE_NUMBER ,D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME, TE.START_DATE, TE.END_DATE
FROM BOAT_EMPLOYEE TE
LEFT JOIN VEHICLE T
on TE.VEHICLE_ID = T.VEHICLE_ID
LEFT JOIN V_EMPLOYEE E
ON TE.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON E.DESIGNATION_ID = D.DESIGNATION_ID
WHERE TE.VEHICLE_ID = " .$vehicle_id ." ORDER BY TE.INSERT_TIME DESC) a order by 1";
        $queryResult = DB::select( $query );

        return response()->json($queryResult);
    }

    private function base_query()
    {
        $query = "SELECT TE.boat_employee_id,
(case when te.active_yn = 'Y' then 'Yes' else 'No' end) as active_yn,
(case when te.team_leader_yn = 'Y' then 'Yes' else 'No' end) as team_leader_yn,
T.VEHICLE_NAME ,TE.MOBILE_NUMBER ,D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME
FROM BOAT_EMPLOYEE TE
LEFT JOIN VEHICLE T
on TE.VEHICLE_ID = T.VEHICLE_ID
LEFT JOIN V_EMPLOYEE E
ON TE.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON E.DESIGNATION_ID = D.DESIGNATION_ID";
        return $query;
    }


    public function post(Request $request)
    {//dd($request);
        $boat_employee_id = $request->get('hidden_boat_employee_id');


        if (isset($request->mobile_number)) {
            $customMessages = [
                'required' => 'The :attribute field is required.',
                'numeric' => 'The :attribute field is must be number.',
            ];

//            $validator = \Validator::make($request->all(), [
////                /* 'boat_employee_id' => 'required',*/
////                /*'mobile_number' => 'numeric|required',*/
//          ],$customMessages);
//
//            if (!$validator->passes()) {
//                $error = array();
//                $error['o_status_code'] = 0;
//                $error['o_status_message'] = $validator->errors()->first();
//
//                return response()->json($error);
//
//            }
        }


        $response = $this->boat_employee_ins_upd($request, $boat_employee_id);

        // $message = $response['o_status_message'];

        $vehicle_id = $request->get('vehicle_id');
        /*        $request->session()->put('team_id',$team_id);*/

        if ($response['o_status_code'] == 1) {

            $boat_employee_id = $response['o_boat_employee_id'];
            $query = $this->base_query() . " WHERE TE.VEHICLE_ID = " . $vehicle_id . " AND TE.BOAT_EMPLOYEE_ID = " . $boat_employee_id;
            $boat_employee = DB::select($query)[0];
            $response['boat_employee'] = $boat_employee;
        }


        return response()->json($response);
    }

    public function update(Request $request)
    {
        $response = array();
        try {
            $boat_employee_id = $request->get('boat_employee_id');
            //$response = $this->team_employee_ins_upd($request, $team_employee_id);
             //dd($boat_employee_id);
            /*BoatEmployee::destroy($boat_employee_id);
            $response['o_status_code'] = 1;
            $response['o_status_message'] = 'Employee removed successfully';*/
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'I_BOAT_EMPLOYEE_ID' => $boat_employee_id,
                'P_INSERT_BY' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            DB::executeProcedure('HYDROAS.BOAT_EMP_DELETE', $params);
 //dd($params);

            if ($params['o_status_code'] != 1)
                DB::rollBack();


            //$affectedRows = BoatEmployee::where('boat_employee_id', '=', $boat_employee_id)->delete();

            $response = array();
            $response['o_status_code'] = $params['o_status_code'];
            if ($response['o_status_code'] != 1) {
                $response['o_status_message'] = 'Deleted failed!!';
            } else {
                $response['o_status_message'] = 'Deleted successfully';
            }
        } catch (\Exception $e) {//dd($e);
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => "Can not delete record is in use !"];
        }


        return response()->json($response);
    }

    /*CREATE OR REPLACE PROCEDURE HYDROAS. (
     IN NUMBER,
           IN NUMBER,
    I_EMP_ID           IN VARCHAR2,
        IN VARCHAR2,
    I_TEAM_LEADER_YN   IN VARCHAR2,
    I_ACTIVE_YN        IN VARCHAR2,
    I_USER_ID          IN NUMBER,
    O_BOAT_EMPLOYEE_ID    OUT NUMBER,

    O_STATUS_CODE     OUT NUMBER,
    O_STATUS_MESSAGE  OUT VARCHAR2)*/
    private function boat_employee_ins_upd(Request $request, $boat_employee_id)
    {
        DB::beginTransaction();
        // dd($boat_employee_id);
        $postData = $request->post();
        //dd($request->all());
        $procedure_name = 'BOAT_EMPLOYEE_INSERT';


        try {

            $vehicle_id = isset($postData['vehicle_id']) ? $postData['vehicle_id'] : '';
            //dd($postData);
            foreach ($postData['emp_id'] as $k => $postDatas) {

                $emp_id = isset($postData['emp_id'][$k]) ? $postData['emp_id'][$k] : '';
                if (!$emp_id)
                    continue;
                $mobile_number = isset($postData['mobile_number'][$k]) ? $postData['mobile_number'][$k] : '';
                $team_leader_yn = isset($postData['team_leader_yn'][$k]) ? $postData['team_leader_yn'][$k] : '';
                $active_yn = isset($postData['active_yn'][$k]) ? $postData['active_yn'][$k] : '';
                $start_date = isset($postData['start_date']) ? date('Y-m-d', strtotime($postData['start_date'])) : '';
                $end_date = isset($postData['end_date']) ? date('Y-m-d', strtotime($postData['end_date'])) : '';

                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
                $o_boat_employee_id = sprintf("%4000s", "");
                $params = [
                    'I_BOAT_EMPLOYEE_ID' => [
                        'value' => $boat_employee_id,
                        'type' => \PDO::PARAM_INT
                    ],
                    'I_VEHICLE_ID' => $vehicle_id,
                    'I_EMP_ID' => $emp_id,
                    'I_MOBILE_NUMBER' => $mobile_number,
//                    'I_TEAM_LEADER_YN' => ($postDatas['team_leader_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                    'I_TEAM_LEADER_YN' => $team_leader_yn,
                    'I_ACTIVE_YN' => $active_yn,
                    'I_START_DATE' => $start_date,
                    'I_END_DATE' => $end_date,
                    //'I_ACTIVE_YN' => ($postDatas['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                    'I_USER_ID' => auth()->id(),
                    'o_boat_employee_id' => &$o_boat_employee_id,
                    'o_status_code' => &$status_code,
                    'o_status_message' => &$status_message,
                ];
                //dd($params);

                \DB::executeProcedure($procedure_name, $params);

                if ($params['o_status_code'] != 1)
                    DB::rollBack();

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }

    public function updateEmp(Request $request)
    {
        //dd($request);

        $boat_employee_id = $request->get('hidden_boat_employee_id_modal');
        $response = $this->boat_employee_upd($request, $boat_employee_id);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.boat-employee-index');
    }

    private function boat_employee_upd(Request $request, $boat_employee_id)
    {
         //dd($boat_employee_id);
        $postData = $request->post();
        //dd($request->all());
        $procedure_name = 'BOAT_EMPLOYEE_INSERT';


        try {
                $vehicle_id = isset($postData['vehicle_id_modal']) ? $postData['vehicle_id_modal'] : '';
                $emp_id = isset($postData['emp_id_modal']) ? $postData['emp_id_modal'] : '';
                $mobile_number = isset($postData['mobile_number_modal']) ? $postData['mobile_number_modal'] : '';
                $team_leader_yn = isset($postData['team_leader_yn_modal']) ? $postData['team_leader_yn_modal'] : '';
                $active_yn = isset($postData['active_yn_modal']) ? $postData['active_yn_modal'] : '';
                $start_date = isset($postData['start_date_modal']) ? date('Y-m-d', strtotime($postData['start_date_modal'])) : '';
                $end_date = isset($postData['end_date_modal']) ? date('Y-m-d', strtotime($postData['end_date_modal'])) : '';

                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
                $o_boat_employee_id = sprintf("%4000s", "");
                $params = [
                    'I_BOAT_EMPLOYEE_ID' => [
                        'value' => $boat_employee_id,
                        'type' => \PDO::PARAM_INT
                    ],
                    'I_VEHICLE_ID' => $vehicle_id,
                    'I_EMP_ID' => $emp_id,
                    'I_MOBILE_NUMBER' => $mobile_number,
                    'I_TEAM_LEADER_YN' => $team_leader_yn,
                    'I_ACTIVE_YN' => $active_yn,
                    'I_START_DATE' => $start_date,
                    'I_END_DATE' => $end_date,
                    'I_USER_ID' => auth()->id(),
                    'o_boat_employee_id' => &$o_boat_employee_id,
                    'o_status_code' => &$status_code,
                    'o_status_message' => &$status_message,
                ];

                \DB::executeProcedure($procedure_name, $params);

        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function getEmp(Request $request)
    {
        $searchTerm = $request->get('term');
        $empId = VEmployee::where(function($query) use ($searchTerm) {
            $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($searchTerm).'%'))
                ->orWhere('emp_code', 'like', ''.trim($searchTerm).'%' );
        })->orderBy('emp_id', 'ASC')->limit(10)->get(['emp_id', 'emp_code', 'emp_name']);

        return $empId;
    }
}
