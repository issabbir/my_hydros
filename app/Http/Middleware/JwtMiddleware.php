<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {

            $token = $request->bearerToken();

            If(!$token){
                throw new \Exception('Token not found');
            }


            $token_info = JWTAuth::getPayload($token)->toArray();
            $user_id = $token_info['sub'];

            $request->attributes->add(['user_id' => $user_id]);

/*            $user = JWTAuth::parseToken()->authenticate();

            if( !$user ) throw new \Exception('User Not Found');*/

        } catch (\Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                return response()->json([

                        'data' => null,

                        'status' => false,

                        'err_' => [

                            'message' => 'Token Invalid',

                            'code' => 1

                        ]

                    ]

                );

            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                return response()->json([

                        'data' => null,

                        'status' => false,

                        'err_' => [

                            'message' => 'Token Expired',

                            'code' =>1

                        ]

                    ]

                );

            }

            else{
                return response()->json(['success' => false, 'error' =>  $e->getMessage()], 500);
            }

        }

        return $next($request);

    }
}
