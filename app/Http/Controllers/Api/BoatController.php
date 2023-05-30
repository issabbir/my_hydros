<?php

namespace App\Http\Controllers\Api;

use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BoatController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/boat/list",
     * summary="BoatList",
     * description="All boat list",
     * operationId="BoatList",
     * tags={"boat"},
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
        $vehicles =  Vehicle::with([])
            ->where('active_yn', '=', YesNoFlag::YES)
            ->orderBy('vehicle_id','ASC')
            ->get(['vehicle_id','vehicle_name','vehicle_name_bn']);

        return response()->json(['success' => true, 'data' => ['vehicles' => $vehicles]], 200);

      //  return response()->json(['foo'=>'bar']);
    }

}
