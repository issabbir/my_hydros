<?php

namespace App\Http\Controllers\Api;

use App\Entities\Setup\LMonth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class YearController extends Controller
{
    //
    /**
     * @OA\Get(
     * path="/api/year/list",
     * summary="MonthList",
     * description="All year list",
     * operationId="yearList",
     * tags={"month_year"},
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
    public function list(){

        $years = array();
        $cur_year = date('Y');
        for ($i=0; $i<=1; $i++) {

            $year = new \stdClass();
            $year->year_id = strval($cur_year);
            $year->year_name = strval ($cur_year);

            array_push($years,$year);
            $cur_year++ ;
        }

        return response()->json(['success' => true, 'data' => ['years' => $years]], 200);

    }
}
