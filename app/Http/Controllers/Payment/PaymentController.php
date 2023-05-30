<?php

namespace App\Http\Controllers\Payment;

use App\Enums\HydroOptionEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\Transaction\TransactionContact;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

	private $transaction_contact;
    private $username = 'hydrographypgw';
    private $password = 'hydrography123456';
    private $moduleid = '37';
    private $pgw_id = '3';

    public function __construct(TransactionContact $transactionContact)
    {
       $this->transaction_contact = $transactionContact;
    }

    //
    public function index(Request $request){
        //dd($request->all());


		$customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;
		$transaction_id = $this->transaction_contact->get_temp_transaction_id($customer_id);
        $amount = $this->transaction_contact->amount_from_selling_transaction($transaction_id);

        $bkash_enable = \DB::table('HYDRO_OPTIONS')
            ->where('option_name', HydroOptionEnum::BKASH_ENABLE)
            ->value('option_value');


        $city_enable = \DB::table('HYDRO_OPTIONS')
            ->where('option_name', HydroOptionEnum::CITY_ENABLE)
            ->value('option_value');
        //dd($transaction_id);
        return view('payment.payment-index', [
            'payment' => null,
			'amount' => $amount,
            'bkash_enable' =>$bkash_enable,
            'city_enable' =>$city_enable,
            'transaction_id' =>$transaction_id,
            'customer_id' =>$customer_id,
            'amount_s' =>10,
            'product_order_id' =>$request->get('product_order_id'),
        ]);
    }

    public function payment_success(Request $request,$id){

        return view('payment.payment-success',[

            "product_order_id"=>$id
        ]);
    }

    public function payment_reject(Request $request){
        return view('payment.payment-reject',[

            "product_order_id"=>null
        ]);
    }

    public function paymentUrl(Request $request)
    {//dd($request->all()); //$request->get('transaction_id')
//dd("Payment url working!");
        //dd(Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_name);
        $params = array(
            'module_table_id' => $request->get('product_order_id'),
            'invoice_no' => $request->get('product_order_id'),
            'amount' => 10,
            'applicant_name' => Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_name,
            'applicant_mobile' => Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->mobile_number,
            'extra_ref_no' =>  $request->get('transaction_id'),
            'username' => $this->username,
            'password' => $this->password,
            'moduleid' => $this->moduleid,
            'pgw_id' => $this->pgw_id,
            'return_url' => route('external-user.payment-response-url', [Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->mobile_number, $request->get('transaction_id')])
        );


        $url = env('AGENT_BILL_PAYMENT_API_URL'); // Instruction from Mahedi Azad Bhai

        DB::beginTransaction();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $body = json_encode($params);

            $log_params = [
                "p_payment_log_id" => [
                    'value' => &$payment_log_id,
                    'type' => \PDO::PARAM_INPUT_OUTPUT,
                    'length' => 255
                ],
                "p_request_url" => $url,
                "p_body" => $body ? $body : '',
                "p_header" => '',
                "p_method" => 'GET',
                "p_response" => '',
                "p_tran_id" => $request->get('transaction_id'),
                "p_challan_response" => '',
                "p_api_tran_id" => '',
                "p_status" => '',
                "p_module_ref_no" => $request->get('product_order_id'),
                "p_insert_BY" => auth()->id(),
                "O_STATUS_CODE" => &$status_code,
                "O_STATUS_MESSAGE" => &$status_message
            ];

            DB::executeProcedure("HYDROAS.BANK_PAYMENT_LOG_ENTRY", $log_params);//dd($log_params);
            //dd($log_params);
            if($log_params['O_STATUS_CODE'] == 1){
                echo $paymentInitInfo = $this->req('GET', $url, [], $params); // API call to make payment
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $response = ["status" => false, "status_code" => 99,  "status_message" => $e->getMessage()];
            return redirect()->back();
        }
        die();
    }

    public function req($method='GET', $url=null, $header=[], $params=[],$sslVerifyYn = 0 ){

        $url = (strtoupper($method) == 'GET' && count($params)>0) ? sprintf("%s?%s", $url, http_build_query($params)) : $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        if(strtoupper($method) == 'POST'){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //json_encode($params));
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $sslVerifyYn);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        $response = curl_exec($ch);

        if(curl_errno($ch)){
            echo curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }

    public function paymentResponseUrl(Request $request, $ap_mbl, $ap_id){

//dd($request);
        //$input_params =$request->get('input_params');
        $input_params =$request->all();

        //api_tran_verify_token
        //session_accesstoken
        $params = array(
            'session_accesstoken' => $input_params['api_tran_verify_token'],
            'username'            => $this->username,
            'password'            => $this->password,
            'moduleid'            => $this->moduleid,
            'pgw_id'              => $this->pgw_id
        );
        $url = env('AGENT_PAYMENT_VERIFY_API_URL');
        echo  $paymentVerifyInfo = $this->req('GET', $url, [], $params);
//        die();

        //$verifyInfo = json_decode($paymentVerifyInfo->PayAmount);
        //dd($paymentVerifyInfo);

        DB::beginTransaction();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            /*$params = array(
                'customer_mobile' => $ap_mbl,
                'transaction_id' => $ap_id,
                'api_tran_id' => $input_params['api_tran_id'],
                'api_tran_date' => $input_params['api_tran_date'],
                'api_tran_vat' => $input_params['api_tran_vat'],
                'api_tran_commission' => $input_params['api_tran_commission'],
                'pay_amount' => $input_params['api_tran_pay_amount'],
                'message' => $input_params['msg'],
                'status' => $input_params['status'],
                'code' => $input_params['code']
            );*/

            $body = $paymentVerifyInfo; //json_encode($params);
            $payment_log_id = null;
            $res_log_params = [
                "p_payment_log_id" => [
                    'value' => &$payment_log_id,
                    'type' => \PDO::PARAM_INPUT_OUTPUT,
                    'length' => 255
                ],
                "p_request_url" => '',
                "p_body" => '',
                "p_header" => '',
                "p_method" => 'POST',
                "p_response" => $body ? $body : '',
                "p_tran_id" => $ap_id,
                "p_challan_response" => '',
                "p_api_tran_id" => $input_params['api_tran_id'] ? $input_params['api_tran_id'] : '',
                "p_status" => $input_params['code'],
                "p_module_ref_no" => $input_params['module_ref_no'],
                "p_insert_BY" => auth()->id(),
                "O_STATUS_CODE" => &$status_code,
                "O_STATUS_MESSAGE" => &$status_message
            ];

            DB::executeProcedure("HYDROAS.BANK_PAYMENT_LOG_ENTRY", $res_log_params);

        } catch (\Exception $e) {
            DB::rollback();
            $response = ["status" => false, "status_code" => 99,  "status_message" => $e->getMessage()];
//            return redirect()->route('payment.pay-now');

            $code = $input_params['code'];
            $message = $input_params['msg'];
            if ($request->session()->has('session_tran_id')) {
                $request->session()->forget('session_tran_id');
            }
            return view('approved-request-index', compact('code', 'message'));
        }

        DB::commit();
        if ($input_params['code'] == 200) {//dd('asdas');
            $code = $input_params['code'];
            $message = $input_params['msg'];

            // transactionId of session null code
            if ($request->session()->has('session_tran_id')) {
                $request->session()->forget('session_tran_id');
            }
            session()->flash('m-class', 'alert-success');
            session()->flash('message', $message);
            return redirect('/external-user/approved-request-index');

            //return view('approved-request-index', compact('code', 'message'));
        }else{
            $code = $input_params['code'];
            $message = $input_params['msg'];

            // transactionId of session null code
            if ($request->session()->has('session_tran_id')) {
                $request->session()->forget('session_tran_id');
            }
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', $message);
            return redirect('/external-user/approved-request-index');
        }

        /*$bill_amount = 10.01; // Test value to check with dummy transaction

        $paid_bills = $this->vslCommonManager->showSelectedBillsByTranId($ap_id);

        if (isset($input_params['status']) && $input_params['status'] == 1) {
            if($input_params['api_tran_pay_amount'] >= $bill_amount) {
                if ($input_params['code'] == 200) {
                    $code = $input_params['code'];
                    $message = $input_params['msg'];

                    $transaction_id = $input_params['api_tran_id']; // This transaction id comes from api and this id is used as PO number in challan

                    // transactionId of session null code
                    if ($request->session()->has('session_tran_id')) {
                        $request->session()->forget('session_tran_id');
                    }

                    return view('payment.payment-response', compact('paid_bills', 'customerInformation', 'code', 'message', 'transaction_id'));

                } elseif ($input_params['code'] != 200) {
                    $code = $input_params['code'];
                    $message = $input_params['msg'];

                    // transactionId of session null code
                    if ($request->session()->has('session_tran_id')) {
                        $request->session()->forget('session_tran_id');
                    }

                    return view('payment.payment-response', compact('code', 'message'));
                }
            } else {
                $code = $input_params['code'];
                $message = $input_params['msg'];

                // transactionId of session null code
                if ($request->session()->has('session_tran_id')) {
                    $request->session()->forget('session_tran_id');
                }

                return view('payment.payment-response', compact('code', 'message'));
            }
        } else {
            $code = $input_params['code'];
            $message = $input_params['msg'];

            // transactionId of session null code
            if ($request->session()->has('session_tran_id')) {
                $request->session()->forget('session_tran_id');
            }

            return view('payment.payment-response', compact('code', 'message'));
        }*/

    }

}
