<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Authorization\AuthContact;
use App\Entities\Pmis\Employee\Employee;
use App\Http\Controllers\Controller;
use App\Managers\Authorization\AuthorizationManager;
use Illuminate\Http\Request;
use JWTAuth;


class UserController extends Controller
{

    /**
     * @var AuthContact|AuthorizationManager
     */
    protected $authManager;

    public function __construct(AuthContact $authManager)
    {
        $this->authManager = $authManager;
        //   $this->middleware('guest')->except('logout');
    }

    /**
     * @OA\Get(
     * path="/api/user/detail",
     * summary="UserDetail",
     * description="User Detail",
     * operationId="UserDetail",
     * tags={"user"},
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

    public function user_detail(Request $request){


        $user_id  = $request->get('user_id');

        $user = $this->authManager->get_user_by_user_id($user_id);

        $employee = Employee::with([])->where('emp_id' ,'=',$user->emp_id)->first();


        return response()->json(['success' => true, 'data' => ['user' => $employee]], 200);


    }
}
