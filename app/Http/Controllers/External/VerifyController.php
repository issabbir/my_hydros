<?php

namespace App\Http\Controllers\External;

use App\Entities\Product\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class VerifyController extends Controller
{
    //
    public function VerifyEmail($id = null, $token = null)
    {
        if($id == null || $token == null) {
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', 'Invalid Login attempt');
            return redirect()->route('external-user-login');

        }

        $response = $this->save_customer($id, $token);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', $message);
            return redirect()->route('external-user-login');

        }
        session()->flash('m-class', 'alert-success');
        session()->flash('message', 'Your account is activated.Now you can log in.');

        return redirect()->route('external-user-login');

    }
    public function forget_password(Request $request){

        return view('user.external-user-forget-password', [
            'user_login' => null
        ]);
    }

    public function forget_password_check(Request $request){
        $email = $request->get('email');
        $customer = Customer::with([])->where('email','=',$email)->first();

        if(!$customer){
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', 'Invalid Email');
            return Redirect::back();
        }

        $customer_name = $customer->customer_name;
        $id = $customer->customer_id;
        $to_name = $email;
        $to_email = $email;
        $forget_password_token = Str::random(32);
        $data = array(
            "name" => $customer_name,
            "body" => "Forget Password mail",
            "id" => $id,
            "forget_password_token" => $forget_password_token
        );
        $app_name = config()->get('app.name');
        \Mail::send('emails.forgetPassword', $data, function ($message) use ($to_name, $to_email, $app_name) {
            $message->to($to_email, $to_name)
                ->subject('Password Recovery Mail');
            $message->from(config('mail.from.address'), $app_name);
        });

        $customer->forget_password_token = $forget_password_token;
        $customer->forget_password_yn = "Y";
        $customer->save();

        $message = 'Please check your mail for account recovery';
        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('forget-password');
    }
    //
    public function forget_password_confirmation($id = null, $token = null)
    {
        if($id == null || $token == null) {
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', 'Invalid Login attempt');
            return redirect()->route('external-user-login');

        }

        $customer_id = $id;

        $customer = Customer::with([])
            ->where('customer_id','=',$customer_id)
            ->where('forget_password_token',$token)
            ->first();

        if(!$customer) {
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', 'Invalid Login attempt');
            return redirect()->route('external-user-login');

        }


        if($customer->forget_password_yn !='Y') {
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', 'Invalid Login attempt');
            return redirect()->route('external-user-login');

        }
        /*$response = "";
        $response->o_status_code = 1;
       // $response = $this->check_forget_password($customer_id, $token);

        $message = "Please change your password";
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', $message);
            return redirect()->route('external-user-login');

        }*/
        session()->flash('m-class', 'alert-success');
        session()->flash('message', 'Your account is recovered.Now you can change your password');

        //$user_registration

        return view('user.external-user-reset-password', [
            'user_registration' => $customer
        ]);

    }

    public function forget_password_save(Request $request){
        $validator = \Validator::make($request->all(),
            [
                'email' => 'required|email',
                'user_password' => 'required|min:6',
                'confirm_user_password' => 'required|same:user_password',
                'captcha' => 'required|captcha',

            ],
            [
                'email.required'=> 'Email is Required', // custom message
                'email.email' => 'Please enter a valid email', // custom message

                'user_password.required' => 'User password is required',
                'user_password.min' => 'User password is minimum 6 character long',
                'confirm_user_password.same' => 'Password and confirm password does not match',


                'captcha.required' => 'Captcha is required',
                'captcha.captcha' => 'Captcha does not match',
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $email = $request->get('email');
        $new_user_password = $request->get('user_password');
        $forget_password_token = $request->get('forget_password_token');

        $response = $this->save_forget_password($email, $new_user_password,$forget_password_token);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            $validator->getMessageBag()->add('error', $message);
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $message = 'Saved successfully.Please login';
        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('external-user-login');


    }

    private function save_forget_password($email, $new_user_password,$forget_password_token)
    {
        $procedure_name = 'FORGET_PASSWORD_PASSWORD_RESET';

        try {
            //use Illuminate\Support\Facades\Hash;
            //$passed = Hash::check($password , $hashed_password); // true
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'I_EMAIL' => $email,
                'I_NEW_USER_PASSWORD' => $new_user_password,
                'I_FORGET_PASSWORD_TOKEN' => $forget_password_token,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];
            \DB::executeProcedure($procedure_name, $params);
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    private function save_customer($id, $email_verification_token)
    {
        $procedure_name = 'CUSTOMER_APPROVAL';

        try {
            //use Illuminate\Support\Facades\Hash;
            //$passed = Hash::check($password , $hashed_password); // true
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $o_customer_id = sprintf("%4000s", "");

            $params = [
                'I_CUSTOMER_TEMP_ID' => $id,
                'I_EMAIL_VERIFICATION_TOKEN' => $email_verification_token,
                'o_customer_temp_id' => &$o_customer_id,
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
