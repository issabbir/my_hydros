<?php

namespace App\Http\Controllers\Api;

use App\Entities\Schedule\BoatEmployee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class DutyRoasterController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/duty-roster",
     * summary="Duty roaster  by boat id, month id ,year id ",
     * description="Duty roaster  by boat id, month id ,year id",
     * operationId="dutyRoster",
     * tags={"dutyRoster"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass  boat_id, month_id ,year_id",
     *    @OA\JsonContent(
     *       required={"boat_id","month_id","year_id"},
     *       @OA\Property(property="boat_id", type="string", format="boat_id", example="2"),
     *       @OA\Property(property="month_id", type="string", format="month_id", example="9"),
     *       @OA\Property(property="year_id", type="string", format="team_id", example="2021"),
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
        $vehicle_id = $request->get('boat_id');
        $month_id = $request->get('month_id');
        $year_id = $request->get('year_id');

        $messages = [
            'required' => ':attribute is required',
        ];
        $rules = [
            'boat_id' => 'required',
            'month_id' => 'required',
            'year_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => $msg,
                'error' => $msg,
                'data' => ''
            ], 200);
        }
        $month_id_zero_padded = sprintf("%02d", $month_id);
        $days = cal_days_in_month(CAL_GREGORIAN, $month_id, $year_id);
        $from_date = $year_id . '/' . $month_id_zero_padded . '/01';
        $to_date = $year_id . '/' . $month_id_zero_padded . '/' . $days;

        /* $boatRosterApproval = BoatRosterApproval::with([])
            ->where('month_id', '=', $month_id)
            ->where('year_id', '=', $year_id)
            ->where('approved_yn', '=', YesNoFlag::YES)
            ->first();
        if (!isset($boatRosterApproval)) {
            return response()->json([
                'success' => false,
                'error' => 'Duty roaster not approved!'
            ], 401);
        } */

        $boat_employees = BoatEmployee::with("employee", "designation")
            ->where('vehicle_id', '=', $vehicle_id)
            ->get();

        foreach ($boat_employees as $boat_employee) {
            if (isset($boat_employee->employee)) {
                $emp_photo = $boat_employee->employee->emp_photo;
                $boat_employee->employee->emp_photo_link = null;
                if ($emp_photo) {
                    $boat_employee->employee->emp_photo_link = route('emp-photo-link', ["id" => $boat_employee->employee->emp_id]);
                }
                unset($boat_employee->employee['emp_photo']);
            }

            $emp_id = $boat_employee->emp_id;
            $query = "SELECT HOLIDAY_YN, to_char(SCHEDULE_DATE, 'DD') DT, to_char(SCHEDULE_DATE, 'MM') MT, to_char(SCHEDULE_DATE, 'YYYY') YR,
                        TO_CHAR(SCHEDULE_FROM_TIME, 'HH24:MI') SCHEDULE_FROM_TIME, TO_CHAR(SCHEDULE_TO_TIME, 'HH24:MI') SCHEDULE_TO_TIME,
                        BER.SCHEDULE_COMMENT, D.DESIGNATION_ID, D.DESIGNATION, E.EMP_NAME, E.EMP_CODE, BE.*
                        FROM BOAT_EMPLOYEE_ROSTER BER
                        INNER JOIN BOAT_EMPLOYEE BE ON BER.BOAT_EMPLOYEE_ID = BE.BOAT_EMPLOYEE_ID
                        LEFT JOIN V_EMPLOYEE E ON BE.EMP_ID = E.EMP_ID
                        LEFT JOIN V_DESIGNATION D ON BE.DESIGNATION_ID = D.DESIGNATION_ID
                        WHERE TRUNC(SCHEDULE_FROM_TIME) >= TO_DATE(:from_date,'YYYY/MM/DD')
                        AND TRUNC(SCHEDULE_TO_TIME) <= TO_DATE(:to_date,'YYYY/MM/DD')
                        AND BE.EMP_ID = :emp_id";

            // WHERE to_char(SCHEDULE_DATE, 'YYYY') = {$year_id} AND to_char(SCHEDULE_DATE, 'MM') = {$month_id_zero_padded}
            // $boat_employee->schedule_details = \DB::select($query);

            $boat_employee->schedule_details = DB::select($query, ["emp_id" => $emp_id, "from_date" => $from_date, "to_date" => $to_date]);
        }

        if (empty($boat_employees)) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Data Not Found!',
                'error' => 'Data Not Found!',
                'data' => ''
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Data Get Successful',
                'error' => '',
                'data' => [
                    'boat_employees' => $boat_employees
                ]
            ], 200);
        }

        /* return view('schedule.duty-roster-approval-index', [
            'vehicles' => Vehicle::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
            'months' => LMonth::with([])->get(),
            'vehicle_id' => $vehicle_id,
            'year_id' => $year_id,
            'month_id' => $month_id_zero_padded,
            'boat_employees' =>$boat_employees,
            'boatRosterApproval' => $boatRosterApproval
        ]); */
    }
}
