<?php

namespace App\Http\Controllers\Setup;

use App\Entities\Setup\LTeamType;
use App\Entities\Setup\Team;
use App\Entities\Setup\TeamEmployee;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TeamEmployeeController extends Controller
{

    public function team_employee_get(Request $request)
    {
        $team_employee_id = $request->get('team_employee_id');

        $response = array();
        $response['o_status_code'] = 1;
        $response['o_status_message'] = 'Data get successfully';

        $response['team_employee'] = TeamEmployee::with([])->find($team_employee_id);

        return response()->json($response);
    }

    public function index(Request $request)
    {

        $teams = Team::with([])->where('active_yn','=',YesNoFlag::YES)->orderBy('team_id', 'DESC')->get();
        $designations = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION ORDER BY DESIGNATION_ID");
        $team_employees = null;
        return view('setup.team-employee-index', [
            'team_employee' => null,
            'team_employees' => null,
            'team' => null,
            'teams' => $teams,
            'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),
            'vehicles' => Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get(),
             'designations' => $designations,
             'employees' => null,

        ]);

    }

    public function designations(){
        $designations = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION ORDER BY DESIGNATION_ID");
        return response()->json($designations);
    }


    public function employee_by_designation(Request $request){
        $designation_id = $request->get('id');
        $employees = DB::select("SELECT EMP_ID as id,EMP_NAME as text FROM V_EMPLOYEE WHERE DESIGNATION_ID = ".$designation_id);
        return response()->json($employees);

    }

    public function employee_detail_from_pims(Request $request){

        $emp_id = $request->get('emp_id');
        $email_query = "SELECT EMP_CONTACT_INFO FROM PMIS.EMP_CONTACTS WHERE EFFECTIVE_YN='Y' AND EMP_ID = '".$emp_id."' AND EMP_CONTACT_TYPE_ID=1";
        $empEmail = DB::select($email_query);
        $mobile_query = "SELECT EMP_CONTACT_INFO FROM PMIS.EMP_CONTACTS WHERE EFFECTIVE_YN='Y' AND EMP_ID = '".$emp_id."' AND EMP_CONTACT_TYPE_ID=2";
        $empMobile = DB::select($mobile_query);

        $array['email']     = "";
        $array['mobile']    = "";
        if(!empty($empEmail))
        {
            $array['email'] = trim($empEmail[0]->emp_contact_info);
        }
        if(!empty($empMobile))
        {
            $array['mobile'] = str_replace(' ','',$empMobile[0]->emp_contact_info);
        }

        return response()->json($array);

    }

    public function edit(Request $request, $id)
    {
        $team_employee = TeamEmployee::with(['team'])->find($id);

        $teams = Team::with([])->where('active_yn','=',YesNoFlag::YES)->get();

        $designations = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION ORDER BY DESIGNATION_ID");

        $employees = DB::select("SELECT EMP_ID,EMP_NAME FROM V_EMPLOYEE");

        return view('setup.team-employee-index', [
            'team_employee' => $team_employee,
            'team' => $team_employee->team,
            'teams' => $teams,
            'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),
            'vehicles' => Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get(),
            'designations' => $designations,
            'employees' => $employees,

        ]);
    }

    public function dataTableList(Request $request)
    {
        $team_id = $request->get('id');

        $query = "SELECT ROWNUM sl, a.*
  FROM (  SELECT TE.team_employee_id,
                 (CASE WHEN te.active_yn = 'Y' THEN 'Yes' ELSE 'No' END)
                     AS active_yn,
                 (CASE WHEN te.team_leader_yn = 'Y' THEN 'Yes' ELSE 'No' END)
                     AS team_leader_yn,
                 T.TEAM_NAME,
                 D.DESIGNATION_ID,
                 D.DESIGNATION,
                 E.EMP_NAME,
                 TE.mobile_no
            FROM TEAM_EMPLOYEE TE
                 LEFT JOIN TEAM T ON TE.TEAM_ID = T.TEAM_ID
                 LEFT JOIN V_EMPLOYEE E ON TE.EMP_ID = E.EMP_ID
                 LEFT JOIN V_DESIGNATION D
                     ON E.DESIGNATION_ID = D.DESIGNATION_ID
           WHERE TE.TEAM_ID = " .$team_id ."
        ORDER BY TE.CREATED_DATE DESC) a order by 1";
        $queryResult = DB::select( $query );

        return response()->json($queryResult);
        /*

        //$queryResult = TeamEmployee::orderBy('team_id', 'DESC')->get();
        return datatables()->of($queryResult)
            ->addColumn('active', function($query) {
                $activeStatus = 'No';

                if($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('team_leader', function($query) {
                $activeStatus = 'No';

                if($query->team_leader_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function($query) {
                return '<a class="teamEmployeeRemove"><i class="bx bx-trash cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);*/
    }

    public function post(Request $request)
    {
        $team_employee_id = $request->get('hidden_team_employee_id');
        $response = $this->team_employee_ins_upd($request,$team_employee_id);

       // $message = $response['o_status_message'];

        $team_id = $request->get('team_id');
        /*        $request->session()->put('team_id',$team_id);*/

        if($response['o_status_code'] == 1) {

            $team_employee_id = $response['o_team_employee_id'];
            $team_employee = DB::select("SELECT TE.team_employee_id,
(case when te.active_yn = 'Y' then 'Yes' else 'No' end) as active_yn,
(case when te.team_leader_yn = 'Y' then 'Yes' else 'No' end) as team_leader_yn,

T.TEAM_NAME ,D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME,TE.mobile_no
FROM TEAM_EMPLOYEE TE
LEFT JOIN TEAM T
on TE.TEAM_ID = T.TEAM_ID
LEFT JOIN V_EMPLOYEE E
ON TE.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON E.DESIGNATION_ID = D.DESIGNATION_ID WHERE TE.TEAM_ID = " .$team_id ." AND TE.TEAM_EMPLOYEE_ID = " .$team_employee_id)[0];
            $response['team_employee'] = $team_employee;
        }


        return response()->json($response);
        /*if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.team-employee-index');*/
    }


    public function update(Request $request)
    {
        $response = array();
        //dd($request->all());
        //dd($id);
        $team_employee_id = $request->get('team_employee_id');
        //$response = $this->team_employee_ins_upd($request, $team_employee_id);
        // dd($response);
        //TeamEmployee::destroy($team_employee_id);

        try {
            $affectedRows = TeamEmployee::where('team_employee_id', '=', $team_employee_id)->delete();

            $response['o_status_code'] = $affectedRows;
            if($affectedRows != 1){
                $response['o_status_message'] = 'Deleted failed!!';
            }else{
                $response['o_status_message'] = 'Deleted successfully';
            }
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => "Can not delete record is in use !"];
        }

        return response()->json($response);
/*
        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.team-employee-index');*/
    }
    private function team_employee_ins_upd(Request $request,$team_employee_id)
    {
        $postData = $request->post();
        $procedure_name = 'TEAM_EMPLOYEE_INSERT';

        try {
            foreach ($postData['emp_id'] as $k => $postDatas) {
                $team_id = isset($postData['team_id']) ? $postData['team_id'] : '';
                $emp_id = isset($postData['emp_id'][$k]) ? $postData['emp_id'][$k] : '';
                $mobile_number = isset($postData['mobile_no'][$k]) ? $postData['mobile_no'][$k] : '';
                $email = isset($postData['email'][$k]) ? $postData['email'][$k] : '';
                $team_leader_yn = isset($postData['team_leader_yn'][$k]) ? $postData['team_leader_yn'][$k] : '';
                $active_yn = isset($postData['active_yn'][$k]) ? $postData['active_yn'][$k] : '';
                //$zonearea_id = null;
                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
                $o_team_employee_id = sprintf("%4000s", "");
                $params = [
                    'I_TEAM_EMPLOYEE_ID' => [
                        'value' => $team_employee_id,
                        'type' => \PDO::PARAM_INT
                    ],
                    'I_TEAM_ID' => $team_id,
                    'I_EMP_ID' => $emp_id,
                    'I_MOBILE_NO' => $mobile_number,
                    'I_EMAIL' =>$email,
                    'I_TEAM_LEADER_YN' =>$team_leader_yn,
                    'I_ACTIVE_YN' => $active_yn,
                    'I_USER_ID' => auth()->id(),
                    'o_team_employee_id' => &$o_team_employee_id,
                    'o_status_code' => &$status_code,
                    'o_status_message' => &$status_message,
                ];

                \DB::executeProcedure($procedure_name, $params);
            }
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
}
