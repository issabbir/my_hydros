<?php

namespace App\Http\Controllers\External;

use App\Entities\Product\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Providers\RouteServiceProvider;

class ExternalLoginController extends Controller
{
    //

    public function external_user_login()
    {
        return view('user.external-user-login', [
            'user_login' => null
        ]);
    }

    public function external_user_login_check(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make([], []);

        $message = 'Missing username/password';
        $user_name = $request->get('user_name');

        if (!$user_name) {
            $validator->getMessageBag()->add('error', $message);
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user_password = $request->get('user_password');

        if (!$user_password) {
            $validator->getMessageBag()->add('error', $message);
            return Redirect::back()->withErrors($validator)->withInput();
        }


        $response = $this->external_login($request);
        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            $validator->getMessageBag()->add('error', $message);
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $customer_id = $response['o_customer_id'];
        $customer = Customer::where('customer_id', $customer_id)->first();

        //return response()->json($customer);

        $guard =  RouteServiceProvider::EXTERNAL_GUARD;

        auth()->guard($guard)->login($customer);

        //Auth::login($customer);

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('external-user.dashboard');
    }

    private function external_login(Request $request)
    {
        $postData = $request->post();
        $procedure_name = 'CUSTOMER_EXTERNAL_LOGIN';

        try {
            $customer_id = sprintf("%4000s", "");
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'I_USER_NAME' => $postData['user_name'],
                'I_USER_PASSWORD' => $postData['user_password'],

                'o_customer_id' => &$customer_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

}
