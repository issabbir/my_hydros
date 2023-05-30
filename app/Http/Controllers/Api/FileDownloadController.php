<?php

namespace App\Http\Controllers\Api;

use App\Entities\Schedule\BoatRosterApproval;
use App\Entities\Schedule\Schedule;
use App\Entities\Setup\LMonth;
use App\Enums\HydroOptionEnum;
use App\Enums\ModuleInfo;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use App\Services\Report\OraclePublisher;
use http\Env\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Entities\Security\Report;

class FileDownloadController extends Controller
{


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


    /**
     * @OA\Get(
     * path="/api/file/list",
     * summary="FileList",
     * description="All file list",
     * operationId="fileList",
     * tags={"file"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */
    public function list()
    {


        $files = array();

        $date = Carbon::now();

        $limit_count = \DB::table('HYDRO_OPTIONS')
            ->where('option_name', HydroOptionEnum::SURVEY_FILE_LIMIT)
            ->value('option_value');
        $schedules = Schedule::with([])
            ->where('approved_yn','=',YesNoFlag::YES)
            ->orderBy('schedule_master_id', 'desc')->take($limit_count)->get();

        foreach ($schedules as $schedule){

            $object = new \stdClass();
            // 1 == SURVEY_FILE
            $object->file_category_id = 1;
            $object->file_category_name = "SURVEY_FILE";
            $object->file_name = $schedule->schedule_name;
            $object->file_type = 'application/pdf';
            $object->file_download_link = route('api-survey-file-download', $schedule->schedule_master_id);
            $object->from_date = $schedule->schedule_from_date->format("Y-m-d");
            $object->to_date = $schedule->schedule_to_date->format("Y-m-d");
            // Add to file
            array_push($files, $object);


        }



        // 2 == DUTY_ROSTER



        $limit_count_for_duty_roster = \DB::table('HYDRO_OPTIONS')
            ->where('option_name', HydroOptionEnum::ROSTER_FILE_LIMIT)
            ->value('option_value');
        $boat_roaster_approvals  = BoatRosterApproval::with("vehicle","month")
            ->where('approved_yn','=',YesNoFlag::YES)
            ->orderBy('boat_roster_approval_id', 'desc')
            ->take($limit_count_for_duty_roster)
            ->get();

        foreach ($boat_roaster_approvals as $boat_roaster_approval){


            if(isset($boat_roaster_approval->month)){
                $object = new \stdClass();
                // 2 == DUTY_ROSTER
                $object->file_category_id = 2;
                $object->file_category_name = "DUTY_ROSTER";

                $object->file_name = $boat_roaster_approval->vehicle->vehicle_name .'-'.
                    $boat_roaster_approval->month->month_name .'-'.$boat_roaster_approval->year_id;
                $object->file_type = 'application/pdf';
                $object->file_download_link = route('api-duty-roster-file-download',["vehicle_id" => $boat_roaster_approval->vehicle->vehicle_id,
                    "month_id" => $boat_roaster_approval->month->month_name ,"year_id" => $boat_roaster_approval->year_id]);

              //  $date = date_create_from_format('m/Y', $boat_roaster_approval->month->month_id.'/'.$boat_roaster_approval->year_id);

                $from_date = date_create_from_format('Y-m-d', $boat_roaster_approval->year_id.'-'.$boat_roaster_approval->month->month_id.'-01')->format("Y-m-d");;
                //date("t");
                $to_date = date_create_from_format('Y-m-d', $boat_roaster_approval->year_id.'-'.$boat_roaster_approval->month->month_id.'-'.date("t", strtotime($from_date)))->format("Y-m-d");;
                 $object->from_date = $from_date;
                 $object->to_date = $to_date;
                // Add to file
                array_push($files, $object);


            }


        }


/*
        $object = new \stdClass();

        $object->file_name = 'Duty roster Test';
        $object->file_category_id = 2;
        $object->file_category_name = 'DUTY_ROSTER';
        $object->file_type = 'image/png';

        $object->file_download_link = route('api-file-download', 107);//'http://www.abcde.com/api/file/download/108';
        $object->from_date = $date->format("Y-m-d");
        $object->to_date = $date->format("Y-m-d");
        // Add to file
        array_push($files, $object);*/

        return response()->json(['success' => true, 'data' => ['files' => $files]], 200);

    }


    /**
     * @OA\Get(
     * path="/api/file/download",
     * summary="FileList",
     * description="All file downlaod link",
     * operationId="fileDownloadList",
     * tags={"file"},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */
    public function download(Request $request, $id)
    {
        $result = DB::table('file_info')
            ->where('file_info_id', '=', $id)
            ->select(array('file_name', 'file_type', 'file_content'))
            ->first();
        $path = public_path($result->file_name);
        $contents = base64_decode($result->file_content);

//store file temporarily
        file_put_contents($path, $contents);

//download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);
    }


    public function survey_file_download(Request $request,$id)
    {
     //   $id = 21;

        $schedule = Schedule::with([])->find($id);

        if(!$schedule){
            return response()->json(['success' => false, 'error' => 'No survey found!'], 401);
        }

        $reportObject = new Report();

        $module = ModuleInfo::EBS_MODULE_ID;

        $report = $reportObject->where('module_id', $module)->where('report_name','Schedule')->orderBy('report_name', 'ASC')->first();


        if(!$report){
            return response()->json(['success' => false, 'error' => 'No report found!'], 401);
        }

        $xdo = $report->report_xdo_path;

        $type = 'pdf';

        $filename = "Schedule.".$type;

        $param_name = $report->params[0]['param_name'];

        $params = array();
        $params['report'] = $report->report_id;
        $params['rid'] = $report->report_id;
        $params[$param_name] = $id;
        //$params['filename'] = $filename;

        $reportContent = $this->oraclePublisher
            ->setXdo($xdo)
            ->setType($type)
            ->setParams($params)->generate();
         return $this->renderPdf($filename,$reportContent);

//        return response()->json($report,200);
    }

    public function duty_roster_file_download($vehicle_id,$month_id,$year_id)
    {
        //   $id = 21;

       /* $schedule = Schedule::with([])->find($id);

        if(!$schedule){
            return response()->json(['success' => false, 'error' => 'No survey found!'], 401);
        }*/

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

//        return response()->json($report,200);
    }

    /**
     * Render pdf
     *
     * @param $reportContent
     * @return \Illuminate\Http\Response
     */
    private function renderPdf($filename,$reportContent) {
        //$filename = $this->fileName?:'file'.".pdf";

        return response()->make($reportContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }




}
