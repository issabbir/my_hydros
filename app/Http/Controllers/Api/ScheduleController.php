<?php

namespace App\Http\Controllers\Api;

use App\Entities\Schedule\BoatEmployee;
use App\Entities\Schedule\BoatRosterApproval;
use App\Entities\Schedule\ScheduleAssignment;
use App\Entities\Setup\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/team/schedule",
     * summary="Team schedule  by team id ",
     * description="Team schedule  by team id",
     * operationId="teamSchedule",
     * tags={"teamSchedule"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass  team_id",
     *    @OA\JsonContent(
     *       required={"team_id"},
     *       @OA\Property(property="team_id", type="string", format="team_id", example="14"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $team_id = $request->get('team_id');


        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        /*

        $messages = [
    'email.required' => 'We need to know your e-mail address!',
];
        */


        $rules = [
            'team_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 401);
        }

/*        $schedules = Schedule::with(
            'team:team_id,team_name,team_name_bn',
            'zonearea:zonearea_id,proposed_name,proposed_name_bn',
            'vehicle:vehicle_id,vehicle_name,vehicle_name_bn')
            ->where('team_id','=',$team_id)
            ->get();*/

/*
        $schedule_assignments = ScheduleAssignment::with("schedule","team","zonearea","vehicle")
            ->where('team_id','=',$team_id)
            ->get();*/

        $query = "SELECT TO_CHAR (A.SCHEDULE_DATE, 'YYYY/MM/DD') \"DATE\",TO_CHAR (A.SCHEDULE_DATE, 'DAY') \"DATE_NAME\",
       (SELECT TEAM_NAME
          FROM HYDROAS.TEAM
         WHERE TEAM_ID = A.TEAM_ID)
          \"TEAM_NAME\",
       (SELECT VEHICLE_NAME
          FROM HYDROAS.VEHICLE
         WHERE VEHICLE_ID = A.VEHICLE_ID)
          \"SHIP_NAME\",
       TO_CHAR (A.SCHEDULE_FROM_TIME, 'HH24:MI') TIME,
       (SELECT PROPOSED_NAME
          FROM HYDROAS.L_ZONEAREA
         WHERE ZONEAREA_ID = A.ZONEAREA_ID)
          \"WORKING_AREA\",
          A.REMARKS REMARKS
          
  FROM HYDROAS.SCHEDULE_ASSIGNMENT A, HYDROAS.SCHEDULE_MASTER M
 WHERE     A.SCHEDULE_MASTER_ID = M.SCHEDULE_MASTER_ID AND A.TEAM_ID = ". $team_id . " ORDER BY A.SCHEDULE_DATE";
        $schedule_assignments = DB::select($query);

        if(!$schedule_assignments || empty($schedule_assignments)){

            return response()->json(['success' => true, 'data' => ['schedules' => $schedule_assignments]], 200);
        }
        $response = array();


        $index = 0;

        foreach ($schedule_assignments as $schedule_assignment){

            $element = new \stdClass();
            $element->index = $index;
            $element->date = $schedule_assignment->date;
            $element->date_name = $schedule_assignment->date_name;
            $element->team_name = $schedule_assignment->team_name;

            //ship_name,time,working_area,remarks
            $element->ship_names = array();
            $ship_element = new \stdClass();
            $ship_element->ship_name = $schedule_assignment->ship_name;
            array_push($element->ship_names,$ship_element);


            $element->times = array();
            $time_element = new \stdClass();
            $time_element->time = $schedule_assignment->time;
            array_push($element->times,$time_element);


            $element->working_areaes = array();
            $working_area_element = new \stdClass();
            $working_area_element->working_area = $schedule_assignment->working_area;
            array_push($element->working_areaes,$working_area_element);

            $element->remarkses = array();
            $remarks_element = new \stdClass();
            $remarks_element->remarks = $schedule_assignment->remarks;
            array_push($element->remarkses,$remarks_element);


            if($this->existsInArray($element,$response)){


                $obj = $this->objectInArray($element,$response);
                $response = $this->array_remove($response,$obj);
                $ship_obj = new \stdClass();
                $ship_obj->ship_name = $schedule_assignment->ship_name;
                array_push($obj->ship_names,$ship_obj);
                $time_obj = new \stdClass();
                $time_obj->time = $schedule_assignment->time;
                array_push($obj->times,$time_obj);
                $working_area_obj = new \stdClass();
                $working_area_obj->working_area = $schedule_assignment->working_area;
                array_push($obj->working_areaes,$working_area_obj);
                $remarks_obj = new \stdClass();
                $remarks_obj->remarks = $schedule_assignment->remarks;
                array_push($obj->remarkses,$remarks_obj);

                array_push($response, $obj);



            }else{
                array_push($response, $element);
                $index++;
            }


        }


        return response()->json(['success' => true, 'data' => ['schedules' => $response]], 200);

    }

    private function existsInArray($entry, $array)
    {
        foreach ($array as $compare) {
            if ($compare->date == $entry->date) {
                return true;
            }
            return false;
        }
    }


    private function objectInArray($entry, $array)
    {
        foreach ($array as $compare) {
            if ($compare->date == $entry->date) {
                return $compare;
            }
            return null;
        }
    }
    private function array_remove(&$array, $value)
    {
        return array_filter($array, function($a) use($value) {
            return $a->date !== $value->date;
        });
    }
}
