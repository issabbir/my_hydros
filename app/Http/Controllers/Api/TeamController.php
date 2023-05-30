<?php

namespace App\Http\Controllers\Api;

use App\Entities\Setup\LMonth;
use App\Entities\Setup\Team;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/team/list",
     * summary="TeamList",
     * description="All team list",
     * operationId="teamList",
     * tags={"team"},
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
        $teams  = Team::with("team_type")
            ->where('active_yn','=',YesNoFlag::YES)
            ->get();
        return response()->json(['success' => true, 'data' => ['teams' => $teams]], 200);

    }
}
