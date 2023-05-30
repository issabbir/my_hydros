<?php

namespace App\Http\Controllers\Api;

use App\Entities\Setup\Team;
use App\Entities\Setup\TeamEmployee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

class TeamEmployeeController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/team/employee/list",
     * summary="Team employee list by team id",
     * description="Team employee list by team id",
     * operationId="teamEmployee",
     * tags={"teamEmployee"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"team_id"},
     *       @OA\Property(property="team_id", type="string", format="team_id", example="15"),
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
    public function list(Request $request){
        $team_id = $request->get('team_id');

        $rules = [
            'team_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 401);
        }

        $team_employees  = TeamEmployee::with("employee","designation")
            ->where('team_id','=',$team_id)
            ->get();
        return response()->json(['success' => true, 'data' => ['team_employees' => $team_employees]], 200);

    }
}
