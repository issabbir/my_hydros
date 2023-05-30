<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Mail\MessageContract;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use DB;

class ForgetPasswordController extends Controller
{
    protected $messageContract;

    /**
     * ForgetPasswordController constructor.
     * @param $messageContract
     */
    public function __construct(MessageContract $messageContract)
    {
        $this->messageContract = $messageContract;
    }

    /**
     * @OA\Post(
     * path="/api/forget-password",
     * summary="Recover password using email",
     * description="Recover password using email",
     * operationId="forgetPassword",
     * tags={"AUTH"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user email",
     *    @OA\JsonContent(
     *       required={"email"},
     *       @OA\Property(property="email", type="string", format="email", example="admin@admin.com"),
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
        try {

            $email = $request->only('email');
            $rules = [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'
                ],
            ];
            $messages = [
                'required' => ':attribute is required.',
                'email' => 'Invalid :attribute address.',
            ];

            $validator = Validator::make($email, $rules, $messages);
            if ($validator->fails()) {
                $msg = $validator->errors()->first();
                return response()->json([
                    'success' => false,
                    'code' => 401,
                    'message' => $msg,
                    'error' => $msg
                ], 200);
            } else {
                $user = User::with(['employee'])->where('email', $email)->first();
                if ($user) {

                    $random_password = Str::random(10);
                    $status_code = sprintf('%4000s', '');
                    $status_message = sprintf('%4000s', '');

                    $params = [
                        "p_USER_ID" => $user->user_id,
                        "p_NEW_PASSWORD" => $random_password,
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message,
                    ];

                    DB::executeProcedure('cpa_security.SECURITY.user_reset_password', $params);

                    $data = [
                        'title' => 'Forget Password',
                        'subject ' => 'Forget Password',
                        'body' => 'Your temporary password is ' . $random_password,
                        'receiver_name' => isset($user->employee) ? $user->employee->emp_name : '',
                        'email' => $email
                    ];

                    $obj = new  SendMail($data, 'Forget Password');
                    $mail = $this->messageContract->sendMail($obj, $email);

                    if ($mail && $params['o_status_code'] == 1) {
                        return response()->json([
                            'success' => true,
                            'code' => 200,
                            'message' => 'An email has been sent to your mail. Please check and change the password',
                            'error' => '',
                            'data' => [
                                'message' => 'An email has been sent to your mail. Please check and change the password'
                            ]
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'code' => 202,
                            'message' => 'Failed to send email, Please try again',
                            'error' => 'Failed to send email, Please try again'
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'code' => 404,
                        'message' => 'This email is not found!',
                        'error' => 'This email is not found!'
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Something went wrong, Please try again later!',
                'error' => $e->getMessage()
            ], 200);
        }
    }
}
