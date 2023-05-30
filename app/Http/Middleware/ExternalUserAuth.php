<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
//https://stackoverflow.com/questions/40993143/how-to-use-authentication-on-custom-model-in-laravel
class ExternalUserAuth
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
        $guard =  RouteServiceProvider::EXTERNAL_GUARD;
        //$user = Auth::guard($guard)->user();

       // return response()->json(Auth::guard($guard)->check());

        if (Auth::guard($guard)->check()) {

            return $next($request);

        }

        $message = RouteServiceProvider::EXTERNAL_ERROR_MESSAGE;
        session()->flash('m-class', 'alert-danger');
        session()->flash('message', $message);
        return redirect(RouteServiceProvider::EXTERNAL_HOME);
    }
}
