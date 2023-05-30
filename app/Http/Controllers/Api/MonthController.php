<?php

namespace App\Http\Controllers\Api;

use App\Entities\Setup\LMonth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonthController extends Controller
{
    //
    /**
     * @OA\Get(
     * path="/api/month/list",
     * summary="MonthList",
     * description="All month list",
     * operationId="monthList",
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
        $months  = LMonth::with([])->get();
        return response()->json(['success' => true, 'data' => ['months' => $months]], 200);

    }
}
