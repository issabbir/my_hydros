<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Schedule\SurveySchedule;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Schedule;
use App\Entities\Setup\Team;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    //
    public function index(Request $request)
    {
        $teams = Team::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $schedule_types = LScheduleType::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $zone_areas = LZoneArea::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $vehicles  = Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get();


        return view('schedule.survey-index', [
            'survey_schedule' => null,
            'schedule_types'=>$schedule_types,
            'teams' => $teams,
            'zone_areas' => $zone_areas,
            'vehicles' =>  $vehicles,
            /*'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),*/
            //'vehicles' => Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get(),

        ]);

    }

    public function edit(Request $request, $id)
    {
        $schedule = Schedule::with(['schedule_type','team','zonearea'])
            ->find($id);

        if(!$schedule){
            $message = "Invalid schedule id !";
            session()->flash('m-class', 'alert-danger');
            return redirect()->route('setup.schedule-index')->with('message', $message);
        }

        $teams = Team::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $schedule_types = LScheduleType::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $zone_areas = LZoneArea::with([])->where('active_yn','=',YesNoFlag::YES)->get();

        $designations = DB::select("SELECT DESIGNATION_ID,DESIGNATION FROM V_DESIGNATION ORDER BY DESIGNATION_ID");

        //$employees = DB::select("SELECT EMP_ID,EMP_NAME FROM V_EMPLOYEE");

        $base_query = $this->schedule_base_query();
        $complete_query = $base_query . " WHERE SD.SCHEDULE_MASTER_ID =  " .$id . " AND SD.ACTIVE_YN = 'Y' ORDER BY SD.SCHEDULE_DETAIL_ID";

        $schedule_details = DB::select($complete_query);
        /*
                $team_id = '';

                if($schedule->team){
                    $team_id = $schedule->team->team_id;
                }

                $team_employees =   DB::select("SELECT TE.*,T.TEAM_NAME ,D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME
        FROM TEAM_EMPLOYEE TE
        LEFT JOIN TEAM T
        on TE.TEAM_ID = T.TEAM_ID
        LEFT JOIN V_EMPLOYEE E
        ON TE.EMP_ID = E.EMP_ID
        LEFT JOIN V_DESIGNATION D
        ON E.DESIGNATION_ID = D.DESIGNATION_ID WHERE TE.TEAM_ID = " .$team_id);
        */

        return view('setup.schedule-index', [
            'schedule' => $schedule,
            'teams' => $teams,
            //'team_employees' => $team_employees,
            'schedule_types'=>$schedule_types,
            'zone_areas' => $zone_areas,
            'designations' => $designations,
            'employees' => null,
            'schedule_details' => $schedule_details,
            'vehicles' => Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get(),


        ]);
    }

    public function dataTableList()
    {
        $queryResult = SurveySchedule::with(['schedule_type'])
            ->where(function ($query) {
                $query->where('approved_yn','=',YesNoFlag::NO)->orWhereNull('approved_yn');
            })
            ->orderBy('survey_schedule_id', 'DESC')
            ->get();
        return datatables()->of($queryResult)
            ->addColumn('active', function($query) {
                $activeStatus = 'No';

                if($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function($query) {
                return '<a href="'. route('setup.schedule-edit', [$query->survey_schedule_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function post(Request $request)
    {
        $response = $this->survey_ins_upd($request,null);

        $message = $response['o_status_message'];

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.schedule-index');
    }


    public function update(Request $request,$id)
    {
        // dd($request->all());
        //dd($id);
        $response = $this->schedule_ins_upd($request, $id);
        // dd($response);

        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.schedule-index');
    }

    public function schedule_detail_post(Request $request){
        $schedule_master_id = $request->get('schedule_master_id');
        $schedule_detail_id = $request->get('schedule_detail_id');

        $response = $this->schedule_detail_ins_upd($request,$schedule_master_id,$schedule_detail_id);

        if($response['o_status_code'] == 1) {

            $base_query = $this->schedule_base_query();
            $complete_query = $base_query . " WHERE SD.SCHEDULE_DETAIL_ID =  " .$response['o_schedule_detail_id'];
            $schedule_detail = DB::select($complete_query)[0];
            $response['schedule_detail'] = $schedule_detail;
        }

        return response()->json($response);
    }

    private function schedule_base_query(){
        $query = "SELECT SD.schedule_detail_id,TO_CHAR(SD.SCHEDULE_FROM_TIME,'HH24:MI') SCHEDULE_FROM_TIME,
        TO_CHAR(SD.SCHEDULE_TO_TIME,'HH24:MI') SCHEDULE_TO_TIME,
        SD.TEAM_EMPLOYEE_YN,
        D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME,(SELECT PROPOSED_NAME FROM L_ZONEAREA WHERE ZONEAREA_ID= SD.ZONEAREA_ID) PROPOSED_NAME
FROM SCHEDULE_DETAIL SD
LEFT JOIN SCHEDULE_MASTER SM
on SD.SCHEDULE_MASTER_ID = SM.SCHEDULE_MASTER_ID
LEFT JOIN V_EMPLOYEE E
ON SD.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON E.DESIGNATION_ID = D.DESIGNATION_ID ";

        return $query;
    }

    private function survey_ins_upd(Request $request,$schedule_id)
    {
        $postData = $request->post();
        $procedure_name = 'SCHEDULE_MASTER_INSERT';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_SCHEDULE_MASTER_ID' => [
                    'value' => $schedule_id
                ],
                'I_SCHEDULE_TYPE_ID' => $postData['schedule_type_id'],
                'I_TEAM_ID' => $postData['team_id'],
                'I_ZONEAREA_ID' => $postData['zonearea_id'],
                'I_SCHEDULE_NAME' => $postData['schedule_name'],
                'I_SCHEDULE_NAME_BN' => $postData['schedule_name_bn'],
                'I_SCHEDULE_FROM_DATE' => $postData['schedule_from_date'],
                'I_SCHEDULE_TO_DATE' => $postData['schedule_to_date'],
                'I_VEHICLE_ID' => $postData['vehicle_id'],
                'I_ACTIVE_YN' => ($postData['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_USER_ID' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
    /*
CREATE OR REPLACE PROCEDURE HYDROAS.SCHEDULE_DETAIL_INSERT (
I_SCHEDULE_DETAIL_ID   IN     NUMBER,
I_SCHEDULE_MASTER_ID   IN     NUMBER,
I_EMP_ID               IN     VARCHAR2,
          IN     NUMBER,
     IN     VARCHAR2,
   IN     VARCHAR2,
     IN     VARCHAR2,
I_ACTIVE_YN            IN     VARCHAR2,
I_USER_ID              IN     NUMBER,
O_SCHEDULE_DETAIL_ID      OUT NUMBER,
O_STATUS_CODE             OUT NUMBER,
O_STATUS_MESSAGE          OUT VARCHAR2)*/
    private function schedule_detail_ins_upd(Request $request,$schedule_master_id,$schedule_detail_id)
    {
        $postData = $request->post();
        $procedure_name = 'SCHEDULE_DETAIL_INSERT';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $o_schedule_detail_id = sprintf("%4000s","");

            $params = [
                'I_SCHEDULE_DETAIL_ID' => [
                    'value' => $schedule_detail_id
                ],
                'I_SCHEDULE_MASTER_ID' => $schedule_master_id,
                'I_EMP_ID' => $postData['emp_id'],
                //'I_ZONEAREA_ID' => $postData['zonearea_id'],
                'I_SCHEDULE_DATE' => $postData['schedule_date'],
                'I_WORK_DESCRIPTION' => $postData['work_description'],

                'I_SCHEDULE_FROM_TIME' => $postData['schedule_from_time'],
                'I_SCHEDULE_TO_TIME' => $postData['schedule_to_time'],

                'I_ACTIVE_YN' => ($postData['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_USER_ID' => auth()->id(),
                'o_schedule_detail_id' => &$o_schedule_detail_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
}
