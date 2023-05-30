<?php

namespace App\Http\Controllers\Schedule;

use Auth;
use App\Entities\Schedule\BoatEmployee;
use App\Entities\Schedule\BoatEmployeeRoster;
use App\Entities\Schedule\IndividualApproval;
use App\Entities\Schedule\Schedule_Mst;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Team;
use App\Entities\Setup\TeamEmployee;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DutyRosterCalenderController extends Controller
{
    //
    public function index(Request $request,$id/*,$month_id,$year_id*/)
    {
        $boat_employee = BoatEmployee::with('employee','designation','vehicle')->find($id);
        $queryResult = IndividualApproval::where('boat_employee_id', '=', $id)->where('active_yn','=','N')->get();

        return view('schedule.duty-roster-calender-index', [
            'boat_employee' => $boat_employee,
            'month_id' => null,//$month_id,
            'year_id' => null,//$year_id,
            'indvApprovalData' => count($queryResult),
            /*'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),*/
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
            'boat_employees' => BoatEmployee::with('employee','designation')->get()

        ]);

    }

    public function boat_index(Request $request,$id/*,$month_id,$year_id*/)
    {//dd($id);

        $boat_employees = BoatEmployee::with("employee","designation")->where('vehicle_id','=',$id)->get();

        $scheduleApprovalData = Schedule_Mst::with([])
            ->where('vehicle_id' , '=', $id )
            ->where('active_yn' , '=', 'N' )
            ->get();

        $vehicle_dtl = Vehicle::with([])->where('vehicle_id','=',$id)->first();
        return view('schedule.duty-roster-calender-index', [
            'vehicle_dtl' => $vehicle_dtl,
            'vehicle_id' => $id,
            'month_id' => null,//$month_id,
            'year_id' => null,//$year_id,
            'boat_employees' => $boat_employees,
            'approvalData' => count($scheduleApprovalData),
            /*'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),*/
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get()

        ]);

    }

    public function employee_roaster(Request $request){
        $boat_employee_id = $request->get('boat_employee_id');


        $boat_id = $request->get('boat_id');

        if(isset($boat_id)){

            $boat_employee = BoatEmployee::with([])->where('vehicle_id','=',$boat_id)->first();

            $boat_employee_rosters =   BoatEmployeeRoster::with([])
                ->where('boat_employee_id','=',$boat_employee->boat_employee_id)
                ->get();

        }else{

            $boat_employee_rosters =   BoatEmployeeRoster::with([])
                ->where('boat_employee_id','=',$boat_employee_id)
                ->get();
        }






        foreach ($boat_employee_rosters as $boat_employee_roster) {
            // code

            if($boat_employee_roster->holiday_yn == 'Y'){

                $boat_employee_roster->title = 'Holiday';
                $boat_employee_roster->backgroundColor = '#F00';

            }else{

                $boat_employee_roster->title = $boat_employee_roster->schedule_comment .
                    '(' .date('H:i', strtotime($boat_employee_roster->schedule_from_time)) .
                    ' to '.date('H:i', strtotime($boat_employee_roster->schedule_to_time)).')';

                if (date('Hi', strtotime($boat_employee_roster->schedule_from_time))=='0000') {
                    $boat_employee_roster->title = "Booked";
                    $boat_employee_roster->backgroundColor = '#C1C700';
                }
            }

            $boat_employee_roster->start = $boat_employee_roster->schedule_date;
            $boat_employee_roster->stick = true;
            $boat_employee_roster->allDay = true;

        }
        return response()->json($boat_employee_rosters);
    }

    public function save(Request $request)
    {
        $message_code = '';
        $message = '';

        DB::beginTransaction();

        try {
            $schedule_form_date = $request->get('schedule_date');
            $schedule_to_date = $request->get('schedule_end_date');
            $boat_id = $request->get('boat_id');

            $startTime = strtotime( $schedule_form_date );
            $endTime = strtotime( $schedule_to_date );

            // Loop between timestamps, 24 hours at a time
            for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
                $schedule_date = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc

                $response = $this->boat_employee_roaster_save($request,$schedule_date,$boat_id);

                if($response['o_status_code'] !=1){
                    throw new \Exception($response['o_status_message']);
                }
            }

            DB::commit();
            $message =  $response['o_status_message'];
            $message_code = $response['o_status_code'];
            // return redirect()->route('external-user.payment-index');
        } catch (\Exception $e) {
            DB::rollback();
            $message_code = 0;
            $message = $e->getMessage();
            // return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            // return redirect()->route('external-user.cart')->with('success_msg',  $e->getMessage());
        }







        $response = array();
        $response['o_status_code'] = $message_code;
        $response['o_status_message'] = $message;

        //return response()->json($response);
        return response()->json($response);
    }

    public function delete_employee_roster(Request $request)
    {
        $boat_employee_roster_id = $request->get('boat_employee_roster_id');

        $boat_id = $request->get('boat_id');

        if(isset($boat_id)){

            /*$boats = BoatEmployee::with([])->where('vehicle_id','=',$boat_id)->get();

            foreach ($boats as $item){




            }*/

            $month_id = $request->get('month_id');
            $year_id = $request->get('year_id');
            $day = $request->get('day');



            $query = <<<QUERY

DELETE
            FROM HYDROAS.BOAT_EMPLOYEE_ROSTER  WHERE TO_CHAR(SCHEDULE_DATE,'DD') = $day AND TO_CHAR(SCHEDULE_DATE,'MM') = lpad($month_id, 2, '0') AND  TO_CHAR(SCHEDULE_DATE,'YYYY') = $year_id AND BOAT_EMPLOYEE_ID in
 (
    SELECT BOAT_EMPLOYEE_ID FROM HYDROAS.BOAT_EMPLOYEE WHERE VEHICLE_ID = $boat_id
 )
QUERY;


            $nrd = DB::delete($query);


        }else{

            BoatEmployeeRoster::destroy($boat_employee_roster_id);

        }


        $response = array();


        $response['o_status_code'] = 1;
        $response['o_status_message'] = 'Roaster removed successfully';

        return response()->json($response);
    }

    private function boat_employee_roaster_save($request,$schedule_date,$boat_id){
        $postData = $request->post();
        $procedure_name = 'BOAT_EMPLOYEE_ROASTER_INSERT';
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_BOAT_EMPLOYEE_ROASTER_ID' =>  null,
                'I_BOAT_EMPLOYEE_ID' => isset($postData['boat_employee_id']) ? $postData['boat_employee_id'] : null,
                'I_SCHEDULE_DATE' =>  $schedule_date,
                'I_SCHEDULE_FROM_TIME' => $postData['schedule_from_time'],
                'I_SCHEDULE_TO_TIME' => $postData['schedule_to_time'],
                'I_SCHEDULE_COMMENT' => $postData['schedule_comment'],
                'I_HOLIDAY_YN' => ($postData['holiday_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_BOAT_ROASTER_YN' => isset($boat_id) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_BOAT_ID' => $boat_id,
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

    public function schedule_post(Request $request)
    {
        $response = $this->schedule_ins_api($request);
        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        //return redirect()->route('training-schedule.training-schedule-index');
        return redirect()->back()->with('message', $message);
    }

    private function createDateRangeArray($strDateFrom,$strDateTo)
    {
        $aryRange = [];

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }

    public function schedule_ins_api(Request $request)
    {//dd($request);
        $postData = $request->post();
        $boat_employees = BoatEmployee::with("employee","designation")->where('vehicle_id','=',$postData['vehicle_id_out'][0])->get();
//dd($boat_employees[0]->boat_employee_id);

        try {
            $status_code = sprintf("%4000s", "");
            $schedule_mst_id = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'P_VEHICLE_ID' => $postData['vehicle_id_out'][0],
                'P_MONTH_ID' => $postData['month_id_out'][0],
                'P_YEAR_ID' => $postData['year_out'][0],
                'P_INSERT_BY' => auth()->id(),
                'O_SCHEDULE_MST_ID' => &$schedule_mst_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            DB::executeProcedure('HYDROAS.SCHEDULE_MST_INSERT', $params);

            if ($params['o_status_code'] != 1) {
                DB::rollBack();
                return $params;
            }

            if ($request->get('schedule_id')) {
                foreach ($request->get('schedule_id') as $indx => $value) {

                    $start_date = isset($request->get('start_date')[$indx]) ? date('Y-m-d', strtotime($request->get('start_date')[$indx])) : '';
                    $end_date = isset($request->get('end_date')[$indx]) ? date('Y-m-d', strtotime($request->get('end_date')[$indx])) : '';

                    $date_range = $this->createDateRangeArray($start_date,$end_date);

                    $startTime = isset($request->get('time_from')[$indx]) ? date('H:i:s', strtotime($request->get('time_from')[$indx])) : '';
                    $endTime = isset($request->get('time_to')[$indx]) ? date('H:i:s', strtotime($request->get('time_to')[$indx])) : '';

                    //$pStartTime = $start_date . ' ' . $startTime;
                    //$pEndTime = $end_date . ' ' . $endTime;


                    foreach ($boat_employees as $indx1 => $value) {
                        foreach ($date_range as $indx2 => $value) {
                            $pStartTime = $date_range[$indx2] . ' ' . $startTime;
                            $pEndTime = $date_range[$indx2] . ' ' . $endTime;
                            if($request->get('schedule_id')[$indx]==1){
                                $holiday = 'N';
                            }else{
                                $holiday = 'Y';
                            }
                            $schedule_dtl_id = sprintf("%4000s", "");
                            $status_code = sprintf("%4000s", "");
                            $status_message = sprintf("%4000s", "");
                            $params_dtl = [
                                "P_SCHEDULE_MST_ID" => $params['O_SCHEDULE_MST_ID'],
                                "P_BOAT_EMPLOYEE_ID" => $boat_employees[$indx1]->boat_employee_id,
                                "P_SCHEDULE_DATE" => $date_range[$indx2],
                                "P_SCHEDULE_FROM_TIME" => $pStartTime,
                                "P_SCHEDULE_TO_TIME" => $pEndTime,
                                "P_ACTIVE_YN" => 'Y',
                                "P_HOLIDAY_YN" => $holiday,
                                "P_INSERT_BY" => auth()->id(),
                                "O_SCHEDULE_DTL_ID" => &$schedule_dtl_id,
                                "o_status_code" => &$status_code,
                                "o_status_message" => &$status_message
                            ];

                            DB::executeProcedure("HYDROAS.SCHEDULE_DTL_INSERT", $params_dtl);
                            if ($params_dtl['o_status_code'] != 1) {
                                DB::rollBack();
                                return $params_dtl;
                            }
                        }
                    }
                }

            }

        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function dataTableList(Request $request)
    {
        $boat_employee_id = $request->get('boat_employee_id');

        $queryResult = IndividualApproval::where('boat_employee_id', '=', $boat_employee_id)->orderBy('active_yn', 'ASC')->get();//dd($queryResult->all());

        return datatables()->of($queryResult)
            ->addColumn('selected', function ($query) {
                if($query->active_yn == 'N'){
                $param = $query->roaster_mst_id;
                $html = <<<HTML
<input type="checkbox" name="roaster_mst_id[]" value="{$param}"/>
HTML;
                return $html;
                }
                return '';
            })
            ->addColumn('holiday', function ($query) {
                $activeStatus = 'No';

                if ($query->holiday_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('schedule_start_date', function ($query) {
                return date('Y-m-d', strtotime($query->schedule_from_time));
            })
            ->addColumn('schedule_end_date', function ($query) {
                return date('Y-m-d', strtotime($query->schedule_to_time));
            })
            ->addColumn('schedule_start_time', function ($query) {
                if ($query->holiday_yn == YesNoFlag::YES) {
                    return '--';
                }
                return date('H:i', strtotime($query->schedule_from_time));
            })
            ->addColumn('schedule_end_time', function ($query) {
                if ($query->holiday_yn == YesNoFlag::YES) {
                    return '--';
                }
                return date('H:i', strtotime($query->schedule_to_time));
            })
            ->addColumn('action', function ($query) {
                if($query->active_yn == 'N'){
                    $userRoles = json_encode(Auth::user()->roles->pluck('role_key'));
                    if (strpos($userRoles, "CHIEF_HYDROGRAPHER") !== FALSE) {
                        $actionBtn = '<a href="javascript:void(0)" class="show-receive-modal editButton" title="Approve"><i class="bx bx-check-circle cursor-pointer"></i></a>';
                        return $actionBtn;
                    }else{
                        $actionBtn = '<span class="badge badge-light">APPROVAL PENDING</span>';
                        $actionBtn .= ' <a target="_self" data-roastermstid="'.$query->roaster_mst_id.'" href="javascript:void(0)" class="text-danger roasterRemove" role="button"><i class="bx bx-trash cursor-pointer"></i></a>';
                        return $actionBtn;
                        /*$html = <<<HTML
<span class="badge badge-light">APPROVAL PENDING</span>
HTML;
                        return $html;*/
                        //return 'APPROVAL PENDING';
                    }

                }else{
                    $html = <<<HTML
<span class="badge badge-primary">APPROVED</span>
HTML;
                    return $html;
                }
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function batchApprove(Request $request) {
        if (count($request->get('roaster_mst_id'))>0) {
            $status_code = 0;
            foreach ($request->get('roaster_mst_id') as $i) {
                $request->request->add(['roaster_mst_id' => $i]);
                $status_code = $this->approveIndividualData($request);
            }

            if ($status_code)
                return back();
        }

        return back();
    }

    public function approveIndividualData(Request $request)
    {//dd($request->all());
        $postData = $request->post();
        $procedure_name = 'DUTY_ROASTER_INDV_APPV';
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'P_ROASTER_MST_ID' => trim($postData['roaster_mst_id']),//intval($postData['roaster_mst_id']),
                'P_UPDATE_BY' => auth()->user()->emp_id,//intval(auth()->user()->emp_id),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];
            \DB::executeProcedure($procedure_name, $params);
            //dd($params);
        }catch (\Exception $e) {
            return $status_code;
        }
        return $status_code;
    }

    public function indvApprvRequest(Request $request)
    {
        $response = $this->indappv_ins_api($request);
        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        //return redirect()->route('training-schedule.training-schedule-index');
        return redirect()->back()->with('message', $message);
    }

    public function indappv_ins_api(Request $request)
    {//dd($request);

        $postData = $request->post();
        $holiday = "N";
        if($postData['schedule_id']=='2'){
            $holiday = 'Y';
        }
        $start_date = isset($postData['schedule_start_date']) ? date('Y-m-d', strtotime($postData['schedule_start_date'])) : '';
        $end_date = isset($postData['schedule_end_date']) ? date('Y-m-d', strtotime($postData['schedule_end_date'])) : '';

        $startTime = isset($postData['dtl_time_from']) ? date('H:i:s', strtotime($postData['dtl_time_from'])) : '';
        $endTime = isset($postData['dtl_time_to']) ? date('H:i:s', strtotime($postData['dtl_time_to'])) : '';

        $pStartTime = $start_date . ' ' . $startTime;
        $pEndTime = $end_date . ' ' . $endTime;

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'P_BOAT_EMPLOYEE_ID' => $postData['boat_employee_id'],
                'P_SCHEDULE_DATE' => $start_date,
                'P_SCHEDULE_FROM_TIME' => $pStartTime,
                'P_SCHEDULE_TO_TIME' => $pEndTime,
                'P_ACTIVE_YN' => 'N',
                'P_HOLIDAY_YN' => $holiday,
                'P_INSERT_BY' => auth()->user()->emp_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            DB::executeProcedure('HYDROAS.ROASTER_INDIVIDUAL_APPV_INS', $params);

            if ($params['o_status_code'] != 1) {
                DB::rollBack();
                return $params;
            }

        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function pendingApprovalRemove(Request $request){
        //dd($request);
        $roaster_mst_id = $request->get("roaster_mst_id");
        $delete = IndividualApproval::where('roaster_mst_id', $roaster_mst_id)->delete();
        return $delete;
    }
}
