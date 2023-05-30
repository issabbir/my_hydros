<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class ExternalRegistrationController extends Controller
{
    // Terms & Conditions
    public function terms_and_conditions() {
        return view('user.terms-and-conditions', [
            'user_registration' => null
        ]);
    }



    //
    public function external_user_registration()
    {
        // Encrypt the message 'Hello, Universe'.
        $encrypted = Crypt::encrypt('1');


// Decrypt the $encrypted message.
        $message   = Crypt::decrypt($encrypted);

        return view('user.external-user-registration', [
            'user_registration' => null
        ]);
    }

    public function external_user_registration_save(Request $request)
    {
        //return response()->json($request->all());

        $validator = \Illuminate\Support\Facades\Validator::make([], []);
        $validator = \Validator::make($request->all(),
            [
                'customer_name' => 'required',
                'email' => 'required|regex:/(.+)@(.+).(.+)/i',
                'user_password' => 'required|min:6',
                'confirm_user_password' => 'required|same:user_password',
                'captcha' => 'required|captcha',

            ],
            [
                'customer_name.required'=> 'Customer name is Required', // custom message
                'email.required'=> 'Email is Required', // custom message
                'email.regex' => 'Please enter a valid email', // custom message

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


        $customer_name = $request->get('customer_name');
        $email = $request->get('email');

        $email_verification_token = Str::random(32);

        //return response()->json($request->all());

        $response = $this->save_reg($request, $email_verification_token);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            $validator->getMessageBag()->add('error', $message);
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $id = $response['o_customer_temp_id'];
        $to_name = $email;
        $to_email = $email;
        $data = array(
            "name" => $customer_name,
            "body" => "Customer verification mail",
            "id" => $id,
            "email_verification_token" => $email_verification_token
        );

        $app_name = config()->get('app.name');
        \Mail::send('emails.verifyEmail', $data, function ($message) use ($to_name, $to_email, $app_name) {
            $message->to($to_email, $to_name)
                ->subject('Account Verification Mail');
            $message->from(config('mail.from.address'), $app_name);
        });

        $message = 'Saved successfully.Please check your mail for account activation';
        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('external-user-registration');

    }

    private function save_reg(Request $request, $email_verification_token)
    {
        $postData = $request->post();
        $procedure_name = 'CUSTOMER_TEMP_SAVE';

        try {
            //use Illuminate\Support\Facades\Hash;
            //$passed = Hash::check($password , $hashed_password); // true
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $o_customer_temp_id = sprintf("%4000s", "");

            $params = [
                'I_CUSTOMER_NAME' => $postData['customer_name'],
                'I_CUSTOMER_ORGANIZATION' => $postData['customer_organization'],
                'I_EMAIL' => $postData['email'],
                'I_MOBILE_NUMBER' => $postData['mobile_number'],
                'I_USER_NAME' => $postData['email'],
                'I_USER_PASSWORD' => $postData['user_password'],
                'I_EMAIL_VERIFICATION_TOKEN' => $email_verification_token,
                'o_customer_temp_id' => &$o_customer_temp_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];
            \DB::executeProcedure($procedure_name, $params);
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    //
    public function VerifyEmail($id,$token = null)
    {
        if($token == null) {

            session()->flash('message', 'Invalid Login attempt');

            return redirect()->route('login');

        }

//        $user = User::where('email_verification_token',$token)->first();

        /*      if($user == null ){

                  session()->flash('message', 'Invalid Login attempt');

                  return redirect()->route('login');

              }*/

        /*        $user->update([

                    'email_verified' => 1,
                    'email_verified_at' => Carbon::now(),
                    'email_verification_token' => ''

                ]);*/

//        session()->flash('message', 'Your account is activated, you can log in now token='.$token);

        // $cryptedpassword = $id;

        $app_name = config()->get('app.name');
        $result = false;
        if($id == "1" ) {
            // Right password
            return response()->json($app_name);
        } else {
            // Wrong one
        }

        return response()->json(false);

    }

}
