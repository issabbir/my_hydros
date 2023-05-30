<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Schedule\ScheduleAssignment;
use App\Entities\Schedule\Schedule_2;
use App\Entities\Schedule\ScheduleAssignment_2;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Schedule\Schedule;
use App\Entities\Setup\Team;
use App\Entities\Setup\TeamEmployee;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleApprovalController extends Controller
{
    //
    public function index(Request $request)
    {
        $teams = Team::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $schedule_types = LScheduleType::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $zone_areas = LZoneArea::with([])->where('active_yn','=',YesNoFlag::YES)->get();

        return view('schedule.schedule-approval-index', [
            'schedule' => null,
            'teams' => $teams,
            'schedule_types'=>$schedule_types,
            'zone_areas' => $zone_areas,
            /*'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),
            'vehicles' => Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get(),*/

        ]);

    }

    public function edit(Request $request, $id,$team_id)
    {
        $schedule_mst = Schedule_2::where('schedule_master_id','=',$id)->first();
        $schedule = Schedule::with(['schedule_type'])
            ->find($id);
//dd(   $schedule);
        if($schedule->active_yn != 'Y') {
            $message = 'Failed to approve a inactive schedule!';
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }
        $team_employee = TeamEmployee::with(['team'])->find($id);
        //$teamid =DB::selectone("select team_id from Team where TEAM_ID =$team_id");
        //dd($team_ids);
        /*$query = "SELECT ROWNUM sl, a.*
  FROM (  SELECT TE.team_employee_id,TE.TEAM_ID,
(case when te.active_yn = 'Y' then 'Yes' else 'No' end) as active_yn,
(case when te.team_leader_yn = 'Y' then 'Yes' else 'No' end) as team_leader_yn,
T.TEAM_NAME ,D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME,TE.mobile_no
FROM TEAM_EMPLOYEE TE
LEFT JOIN TEAM T
on TE.TEAM_ID = T.TEAM_ID
LEFT JOIN V_EMPLOYEE E
ON TE.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON E.DESIGNATION_ID = D.DESIGNATION_ID WHERE TE.TEAM_ID = $team_id ORDER BY TE.INSERT_TIME DESC) a order by 1";//latest 13-1-2022*/
        $query = "SELECT ROWNUM sl, a.*
    FROM (  SELECT DISTINCT
                   TE.team_employee_id,
                   TE.TEAM_ID,
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
                   LEFT JOIN HYDROAS.SCHEDULE_ASSIGNMENT sa
                       ON TE.TEAM_ID = sa.TEAM_ID
             WHERE sa.SCHEDULE_MASTER_ID = $id
          ORDER BY TE.TEAM_ID) a
ORDER BY 1";
        /*$query = "SELECT TE.team_employee_id,TE.TEAM_ID,
(case when te.active_yn = 'Y' then 'Yes' else 'No' end) as active_yn,
(case when te.team_leader_yn = 'Y' then 'Yes' else 'No' end) as team_leader_yn,
T.TEAM_NAME ,D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME,TE.mobile_no
FROM TEAM_EMPLOYEE TE
LEFT JOIN TEAM T
on TE.TEAM_ID = T.TEAM_ID
LEFT JOIN V_EMPLOYEE E
ON TE.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON E.DESIGNATION_ID = D.DESIGNATION_ID WHERE TE.TEAM_ID = $team_id ORDER BY TE.TEAM_LEADER_YN DESC";*/
//dd($query);
        $queryResult = DB::select( $query );

        $teams = Team::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $schedule_types = LScheduleType::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $zone_areas = LZoneArea::with([])->where('active_yn','=',YesNoFlag::YES)->get();


        $schedule_assignments = ScheduleAssignment::with("team",'vehicle','zonearea')
            ->where('schedule_master_id','=',$id)
            ->orderBy('SCHEDULE_DATE','ASC')
            ->orderBy('TEAM_ID','ASC')
            ->get();

        return view('schedule.schedule-approval-index', [
            'schedule_mst' => $schedule_mst,
            'schedule' => $schedule,
            'schedule_master_id' => $id,
            'teams' => $teams,
            'schedule_types'=>$schedule_types,
            'zone_areas' => $zone_areas,
            'vehicles' => Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get(),
            'schedule_assignments' => $schedule_assignments,
            'queryResult'=>$queryResult,
            'team_employee'=>$team_employee,

        ]);
    }

    public function dataTableList()
    {
        /*$queryResult = ScheduleAssignment_2::with(['team','schedule2'])

            //->where('active_yn','=',YesNoFlag::YES)
            ->where(function ($query) {
//             $query->where('approved_yn','=',YesNoFlag::YES)->orWhereNull('approved_yn');
            })

            ->orderBy('schedule_master_id','DESC')
            ->get();*/
        $queryResult = Schedule_2::orderBy('insert_time','DESC')
            ->get();

//dd($queryResult);
        return datatables()->of($queryResult)
            ->addColumn('rejected', function($query) {
                $activeStatus = 'No';

                //if($query->schedule2->rejected_yn == YesNoFlag::YES) {
                if($query->rejected_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('approved', function($query) {
                $activeStatus = 'No';

                //if($query->schedule2->approved_yn == YesNoFlag::YES) {
                if($query->approved_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function($query) {
                return '<a  href="'. route('schedule.schedule-approval-edit', [$query->schedule_master_id,/*$query->team_id*/'team']) .'"><i class="bx bx-right-arrow-alt cursor-pointer"></a>';
            })
            ->addIndexColumn()
            ->make(true);

    }


    public function update(Request $request,$id)
    {
        // dd($request->all());
        //dd($id);

        $schedule_master_id = $id;
        $remarks = $request->get('remarks');
        $approved_yn = $request->get('approve_yn');

        $response = $this->schedule_approval_by_update($schedule_master_id,$remarks,$approved_yn);
        // dd($response);

        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.schedule-approval-index');
    }

    private function schedule_approval_by_update($schedule_master_id,$remarks,$approved_yn)
    {
        $procedure_name = 'SCHEDULE_APPROVAL';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $o_schedule_detail_id = sprintf("%4000s","");

            $params = [
                'I_SCHEDULE_MASTER_ID' => $schedule_master_id,
                'I_REMARKS' => $remarks,
                'I_ACTIVE_YN' => ($approved_yn == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
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
}
