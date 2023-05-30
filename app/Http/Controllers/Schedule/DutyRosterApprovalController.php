<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Schedule\BoatEmployee;
use App\Entities\Schedule\BoatEmployeeRoster;
use App\Entities\Schedule\BoatRosterApproval;
use App\Entities\Security\Report;
use App\Entities\Setup\LMonth;
use App\Entities\Setup\Vehicle;
use App\Enums\ModuleInfo;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use App\Services\Report\OraclePublisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class DutyRosterApprovalController extends Controller
{
    //


    /** @var OraclePublisher  */
    private $oraclePublisher;


    /**
     * OraclePublisherController constructor.
     * @param OraclePublisher $oraclePublisher
     */
    public function __construct(OraclePublisher $oraclePublisher)
    {
        $this->oraclePublisher = $oraclePublisher;
    }

    //
    public function index(Request $request)
    {

        //hydrography_admin
        if(auth()->user()->getRoles()->pluck( 'role_key' )->contains('hydrography_admin')){

        }


        return view('schedule.duty-roster-approval-index', [
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
            'months' => LMonth::with([])->get(),
            'vehicle_id' => null,
            'year_id' => null,
            'month_id' => null,
            'boat_employees' =>null,
            'boatRosterApproval' => null

        ]);
    }

/*
        public function post(Request $request)
    {
        $vehicle_id = $request->get('vehicle_id');
        $month_id = $request->get('month_id');
        $year_id = $request->get('year_id');

        $month_id_zero_padded = sprintf("%02d", $month_id);

        $boatRosterApproval = BoatRosterApproval::with([])
            ->where('month_id' , '=', $month_id )
            ->where('year_id' , '=', $year_id )
            ->first();

        $boat_employees = BoatEmployee::with("employee","designation")
            ->where('vehicle_id' , '=',$vehicle_id )
            ->get();

        foreach ($boat_employees as $boat_employee){

            $emp_id = $boat_employee->emp_id;
            $query = "
SELECT HOLIDAY_YN, to_char(SCHEDULE_DATE, 'DD') DT,to_char(SCHEDULE_DATE, 'MM') MT,to_char(SCHEDULE_DATE, 'YYYY') YR,
TO_CHAR(SCHEDULE_FROM_TIME,'HH24:MI') SCHEDULE_FROM_TIME,TO_CHAR(SCHEDULE_TO_TIME,'HH24:MI') SCHEDULE_TO_TIME, BER.SCHEDULE_COMMENT,
D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME,BE.*
FROM BOAT_EMPLOYEE_ROSTER BER
INNER JOIN BOAT_EMPLOYEE BE
ON BER.BOAT_EMPLOYEE_ID = BE.BOAT_EMPLOYEE_ID
LEFT JOIN V_EMPLOYEE E
ON BE.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON BE.DESIGNATION_ID = D.DESIGNATION_ID
WHERE to_char(SCHEDULE_DATE, 'YYYY') = {$year_id} AND to_char(SCHEDULE_DATE, 'MM') = {$month_id_zero_padded}
AND BE.EMP_ID = {$emp_id}";
            $boat_employee->schedule_details = \DB::select($query);
        }


        return view('schedule.duty-roster-approval-index', [
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
            'months' => LMonth::with([])->get(),
            'vehicle_id' => $vehicle_id,
            'year_id' => $year_id,
            'month_id' => $month_id_zero_padded,
            'boat_employees' =>$boat_employees,
            'boatRosterApproval' => $boatRosterApproval

        ]);

    }*/

    private  function get_boat_employees($vehicle_id,$month_id,$year_id){


        $month_id_zero_padded = sprintf("%02d", $month_id);

        $boat_employees = BoatEmployee::with([])
            ->where('vehicle_id' , '=',$vehicle_id )
            ->get();

        foreach ($boat_employees as $boat_employee){

            $emp_id = $boat_employee->emp_id;
            $query = "
SELECT  HOLIDAY_YN,to_char(SCHEDULE_DATE, 'DD') DT,to_char(SCHEDULE_DATE, 'MM') MT,to_char(SCHEDULE_DATE, 'YYYY') YR,
TO_CHAR(SCHEDULE_FROM_TIME,'HH24:MI') SCHEDULE_FROM_TIME,TO_CHAR(SCHEDULE_TO_TIME,'HH24:MI') SCHEDULE_TO_TIME, BER.SCHEDULE_COMMENT,
D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME,BE.*
FROM BOAT_EMPLOYEE_ROSTER BER
INNER JOIN BOAT_EMPLOYEE BE
ON BER.BOAT_EMPLOYEE_ID = BE.BOAT_EMPLOYEE_ID
LEFT JOIN V_EMPLOYEE E
ON BE.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON BE.DESIGNATION_ID = D.DESIGNATION_ID
WHERE to_char(SCHEDULE_DATE, 'YYYY') = '[$year_id]' AND to_char(SCHEDULE_DATE, 'MM') = '[$month_id_zero_padded]'
AND BE.EMP_ID = '[$emp_id]'";
            $boat_employee->schedule_details = \DB::select($query);
        }

        return $boat_employees;
    }

    public function save(Request $request)
    {
        $vehicle_id = $request->get('vehicle_id');
        $boat_employees = BoatEmployee::with("employee","designation")->where('vehicle_id','=',$vehicle_id)->get();
        //$month_id = $request->get('month_id');
        //$year_id = $request->get('year_id');

        $querys = "SELECT HYDROAS.SHEDULE_DATE_RANGE ('".$vehicle_id."') FROM DUAL" ;
        $scheduleData = DB::select($querys);//dd($scheduleData);
        if(!empty($scheduleData)){
            $scheduleData = $scheduleData[0];
        }else{
            $scheduleData = null;
        }
        /*$scheduleData = DB::select("SELECT distinct(SAD.SCHEDULE_DATE), SAD.SCHEDULE_MST_ID, SAD.SCHEDULE_FROM_TIME, SAD.SCHEDULE_TO_TIME,
SAD.HOLIDAY_YN, SAM.VEHICLE_ID, SAM.MONTH_ID, SAM.YEAR_ID FROM SCHEDULE_APPROVAL_MST SAM
LEFT JOIN SCHEDULE_APPROVAL_DTL SAD ON (SAD.SCHEDULE_MST_ID = SAM.SCHEDULE_MST_ID)
WHERE SAM.VEHICLE_ID = :VEHICLE_ID
AND SAM.ACTIVE_YN = 'N'
AND SAM.MONTH_ID = :MONTH_ID
AND SAM.YEAR_ID = :YEAR_ID", ['VEHICLE_ID' => $vehicle_id, 'MONTH_ID' => $month_id, 'YEAR_ID' => $year_id]);

        $month_id_zero_padded = sprintf("%02d", $month_id);

        $boatRosterApproval = BoatRosterApproval::with([])
            ->where('month_id' , '=', $month_id )
            ->where('year_id' , '=', $year_id )
            ->first();

        $boat_employees = BoatEmployee::with("employee","designation")
            ->where('vehicle_id' , '=',$vehicle_id )
            ->get();

        foreach ($boat_employees as $boat_employee){

            $emp_id = $boat_employee->emp_id;
            $query = "
SELECT HOLIDAY_YN, to_char(SCHEDULE_DATE, 'DD') DT,to_char(SCHEDULE_DATE, 'MM') MT,to_char(SCHEDULE_DATE, 'YYYY') YR,
TO_CHAR(SCHEDULE_FROM_TIME,'HH24:MI') SCHEDULE_FROM_TIME,TO_CHAR(SCHEDULE_TO_TIME,'HH24:MI') SCHEDULE_TO_TIME, BER.SCHEDULE_COMMENT,
D.DESIGNATION_ID,D.DESIGNATION,E.EMP_NAME,BE.*
FROM BOAT_EMPLOYEE_ROSTER BER
INNER JOIN BOAT_EMPLOYEE BE
ON BER.BOAT_EMPLOYEE_ID = BE.BOAT_EMPLOYEE_ID
LEFT JOIN V_EMPLOYEE E
ON BE.EMP_ID = E.EMP_ID
LEFT JOIN V_DESIGNATION D
ON BE.DESIGNATION_ID = D.DESIGNATION_ID
WHERE to_char(SCHEDULE_DATE, 'YYYY') = {$year_id} AND to_char(SCHEDULE_DATE, 'MM') = {$month_id_zero_padded}
AND BE.EMP_ID = {$emp_id}";
            $boat_employee->schedule_details = \DB::select($query);
        }*/


        return view('schedule.duty-roster-approval-index', [
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
            'months' => LMonth::with([])->get(),
            'scheduleData' => $scheduleData,
            'vehicle_id' => $vehicle_id,
            'year_id' => null, //$year_id,
            'month_id' => null,//$month_id_zero_padded,
            'boat_employees' =>$boat_employees,//$boat_employees,
            'boatRosterApproval' => null,//$boatRosterApproval,
            'month_selected' =>''//LMonth::with([])->find($month_id)

        ]);
    }


    public function approve(Request $request){

        $response = $this->boat_employee_roster_approval($request,null);
        return response()->json($response);
    }
    private function boat_employee_roster_approval(Request $request,$boat_employee_roster_approval_id)
    {
        /*$postData = $request->post();
        $procedure_name = 'BOAT_ROSTER_APPROVAL_INSERT';

        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $o_boat_employee_id = sprintf("%4000s","");
            $params = [
                'I_BOAT_ROSTER_APPROVAL_ID' => [
                    'value' => $boat_employee_roster_approval_id,
                    'type' => \PDO::PARAM_INT
                ],
                'I_APPROVED_BY' => auth()->user()->emp_id,
                'I_REMARKS' => isset($postData['remarks']) ? $postData['remarks'] : '',
                'I_APPROVED_YN' => ($postData['approved_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_VEHICLE_ID' => $postData['vehicle_id'],
                'I_YEAR_ID' => isset($postData['year_id']) ? $postData['year_id'] : '',
                'I_MONTH_ID' => isset($postData['month_id']) ? $postData['month_id'] : '',
                'I_USER_ID' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        }*/

        $postData = $request->post();
        $procedure_name = 'SCHEDULE_REJECT';
        /*p_SCHEDULE_MST_ID   IN     NUMBER,
    p_VEHICLE_ID        IN     VARCHAR2,
    p_REJECT_N          IN     VARCHAR2,
    p_REJECT_BY         IN     NUMBER,*/

        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $o_boat_employee_id = sprintf("%4000s","");
            $params = [
                'p_SCHEDULE_MST_ID' => isset($postData['schedule_mst_id']) ? $postData['schedule_mst_id'] : '',
                'p_VEHICLE_ID' => isset($postData['vehicle_id']) ? $postData['vehicle_id'] : '',
                'p_REJECT_N' => 'N',
                'p_REJECT_BY' => auth()->user()->emp_id,
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



    public function downloadPDF($vehicle_id,$month_id,$year_id) {

        $reportObject = new Report();

        $module = ModuleInfo::EBS_MODULE_ID;

        $report = $reportObject->where('module_id', $module)->where('report_name','DutyRoster')->orderBy('report_name', 'ASC')->first();


        if(!$report){
            return response()->json(['success' => false, 'error' => 'No report found!'], 401);
        }

        $xdo = $report->report_xdo_path;

        $type = 'pdf';

        $filename = "DutyRoster.".$type;

        $param_name = $report->params[0]['param_name'];

        $params = array();
        $params['report'] = $report->report_id;
        $params['rid'] = $report->report_id;

        $params_array = array();
        foreach ($report->params as $report_param){


            if($report_param->param_name=="P_SCHEDULE_MONTH"){

                $params["P_SCHEDULE_MONTH"] = $month_id;
            }


            if($report_param->param_name=="P_SCHEDULE_YEAR"){

                $params["P_SCHEDULE_YEAR"] = $year_id;
            }


            if($report_param->param_name=="P_VEHICLE_ID"){

                $params["P_VEHICLE_ID"] = $vehicle_id;
            }

        }

        //$params['filename'] = $filename;

        $reportContent = $this->oraclePublisher
            ->setXdo($xdo)
            ->setType($type)
            ->setParams($params)->generate();
        return $this->renderPdf($filename,$reportContent);
    }

    private function renderPdf($filename,$reportContent) {
        //$filename = $this->fileName?:'file'.".pdf";

        return response()->make($reportContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

}
