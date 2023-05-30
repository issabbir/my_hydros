<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Schedule\BoatEmployee;
use App\Entities\Schedule\ScheduleAssignment;
use App\Entities\Security\Report;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LTeamType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Schedule\Schedule;
use App\Entities\Setup\Team;
use App\Entities\Setup\Vehicle;
use App\Enums\HydroOptionEnum;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    //
    public function index(Request $request)
    {
        $teams = Team::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $schedule_types = LScheduleType::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $zone_areas = LZoneArea::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $limit_count = \DB::table('HYDRO_OPTIONS')
            ->where('option_name', HydroOptionEnum::SURVEY_FILE_LIMIT)
            ->value('option_value');
        $schedules = Schedule::with([])
            ->where('approved_yn','=',YesNoFlag::YES)
            ->orderBy('schedule_master_id', 'desc')->take($limit_count)->get();

        return view('schedule.schedule-index', [
            'schedule' => null,
            'teams' => $teams,
            'schedules' => $schedules,
            'report' => Report::find(200),
            'schedule_types'=>$schedule_types,
            'zone_areas' => $zone_areas,
            /*'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),*/
            'vehicles' => Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get(),

        ]);

    }

    public function edit(Request $request, $id)
    {
        $limit_count = \DB::table('HYDRO_OPTIONS')
            ->where('option_name', HydroOptionEnum::SURVEY_FILE_LIMIT)
            ->value('option_value');
        $schedules = Schedule::with([])
            ->where('approved_yn','=',YesNoFlag::YES)
            ->orderBy('schedule_master_id', 'desc')->take($limit_count)->get();
        $schedule = Schedule::with(['schedule_type'])
            ->find($id);

        if(!$schedule){
            $message = "Invalid schedule id !";
            session()->flash('m-class', 'alert-danger');
            return redirect()->route('schedule.schedule-index')->with('message', $message);
        }

        $teams = Team::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $schedule_types = LScheduleType::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        $zone_areas = LZoneArea::with([])->where('active_yn','=',YesNoFlag::YES)->get();
//dd($schedule);
        $schedule_assignments = ScheduleAssignment::with("team",'vehicle','zonearea')
            ->where('schedule_master_id','=',$id)
            ->get();

        return view('schedule.schedule-index', [
            'schedule' => $schedule,
            'schedule_master_id' => $id,
            'teams' => $teams,
            'schedules' => $schedules,
            'report' => Report::find(200),
            //'team_employees' => $team_employees,
            'schedule_types'=>$schedule_types,
            'zone_areas' => $zone_areas,
            'schedule_assignments' => $schedule_assignments,
            'vehicles' => Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get(),


        ]);
    }

    public function dataTableList()
    {
        $queryResult = Schedule::with(['schedule_type'])
            ->where(function ($query) {
                $query->where('approved_yn','=',YesNoFlag::NO)->orWhereNull('approved_yn');
            })
            ->orderBy('schedule_master_id', 'DESC')
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
                return '<a href="'. route('schedule.schedule-edit', [$query->schedule_master_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function post(Request $request)
    {
        $response = $this->schedule_ins_upd($request,null);

        $message = $response['o_status_message'];

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.schedule-index');
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

        return redirect()->route('schedule.schedule-index');
    }

    public function schedule_detail_post(Request $request){
        $schedule_master_id = $request->get('schedule_master_id');
        $schedule_assigment_id = $request->get('schedule_assigment_id');

        $response = $this->schedule_assignment_ins_upd($request,$schedule_master_id,$schedule_assigment_id);

        if($response['o_status_code'] == 1) {
            $schedule_assigment_id = $response['o_schedule_assigment_id'];
            $schedule_assignment = ScheduleAssignment::with("team",'vehicle','zonearea')->find($schedule_assigment_id);
            $response['schedule_assignment'] = $schedule_assignment;
        }

        return response()->json($response);
    }

    public function schedule_assignment_delete(Request $request){
        $schedule_master_id = $request->get('schedule_master_id');
        $schedule_assignment_id = $request->get('schedule_assignment_id');


        ScheduleAssignment::destroy($schedule_assignment_id);
        $response = array();
        $response['o_status_code'] = 1;
        $response['o_status_message'] = 'Deleted successfully';
        /*if($response['o_status_code'] == 1) {
            $schedule_assigment_id = $response['o_schedule_assigment_id'];
            $schedule_assignment = ScheduleAssignment::with("team",'vehicle','zonearea')->find($schedule_assigment_id);
            $response['schedule_assignment'] = $schedule_assignment;
        }*/

        return response()->json($response);
    }

    private function schedule_ins_upd(Request $request,$schedule_id)
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
                'I_SCHEDULE_NAME' => $postData['schedule_name'],
                'I_SCHEDULE_NAME_BN' => $postData['schedule_name_bn'],
                'I_DESCRIPTION' => $postData['description'],
                'I_SCHEDULE_FROM_DATE' => $postData['schedule_from_date'],
                'I_SCHEDULE_TO_DATE' => $postData['schedule_to_date'],
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

    private function schedule_assignment_ins_upd(Request $request,$schedule_master_id,$schedule_assignment_id)
    {
        $postData = $request->post();//dd($postData);
        $procedure_name = 'SCHEDULE_ASSIGNMENT_INSERT';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $o_schedule_assignement_id = sprintf("%4000s","");

            $params = [
                'I_SCHEDULE_ASSIGNMENT_ID' => [
                    'value' => $schedule_assignment_id
                ],
                'I_SCHEDULE_MASTER_ID' => $schedule_master_id,

                'I_TEAM_ID' => $postData['team_id'],
                'I_ZONEAREA_ID' => $postData['zonearea_id'],
                'I_VEHICLE_ID' => $postData['vehicle_id'],
                'I_SCHEDULE_DATE' => $postData['schedule_date'],
                'I_SCHEDULE_FROM_TIME' => $postData['schedule_from_time'],
                'I_SCHEDULE_TO_TIME' => $postData['schedule_to_time'],
                'I_REMARKS' => $postData['remarks'],
                'I_ACTIVE_YN' => ($postData['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_DESCRIPTION' => $postData['description'],
                'I_USER_ID' => auth()->id(),
                'o_schedule_assigment_id' => &$o_schedule_assignement_id,
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
