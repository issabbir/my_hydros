<?php

namespace App\Http\Controllers\Payment;

use App\Contracts\LogContact;
use App\Contracts\NotificationContact;
use App\Entities\Product\Customer;
use App\Entities\Product\ProductOrder;
use App\Entities\Transaction\TempTransaction;
use App\Enums\BkashConstant;
use App\Enums\Gateway;
use App\Enums\PaymentConstant;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use App\Managers\LogManager;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Transaction\TransactionContact;
use App\Contracts\Payment\BkashContact;

class BkashController extends Controller
{

    private $transaction_contact;
    private $bkash_contact;
    private $log_contact;
    private $notification_contact;

    public function __construct(TransactionContact $transactionContact, BkashContact $bkash_contact,LogContact $log_contact,NotificationContact $notification_contact)
    {
        $this->transaction_contact = $transactionContact;
        $this->bkash_contact = $bkash_contact;
        $this->log_contact = $log_contact;
        $this->notification_contact = $notification_contact;
    }

    public function create(Request $request)
    {

        $token_response = $this->bkash_contact->create_token();
        $this->log_contact->save_payment_log(null,PaymentConstant::TOKEN_REQUEST,YesNoFlag::NO,$token_response);
        $id_token = $token_response->id_token;
        $request->session()->put('id_token', $id_token);

        $payerReference = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->mobile_number;
        //$customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;
        $transaction_id = $this->transaction_contact->get_temp_transaction_id();
        $amount = $this->transaction_contact->amount_from_selling_transaction($transaction_id);

        $merchantInvoiceNumber = $transaction_id;

        $create_response = $this->bkash_contact->create_payment($id_token, $payerReference, $amount, $merchantInvoiceNumber);
        $this->log_contact->save_payment_log($transaction_id,PaymentConstant::CREATE_PAYMENT,YesNoFlag::NO,$token_response);

        $bank_transaction_id = $create_response->paymentID;

        $gateway_id = Gateway::BKASH;

     /*   $response = $this->transaction_contact->selling_transaction_update($transaction_id, $bank_transaction_id, $gateway_id);
        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            return response()->json($response);;
        }*/

        $this->log_contact->save_payment_log($transaction_id,PaymentConstant::SELLING_TRANSACTION_INSERT,YesNoFlag::NO,$token_response);

        return response()->json($create_response);
    }


    public function execute(Request $request)
    {
        $paymentID = $request->get('paymentID');
        $id_token = $request->session()->get('id_token');

        $request->session()->put('paymentID', $paymentID);

        $transaction_id = $this->transaction_contact->get_temp_transaction_id();

        $execute_response = $this->bkash_contact->execute_payment($id_token, $paymentID);
        $this->log_contact->save_payment_log($transaction_id,PaymentConstant::EXECUTE_PAYMENT,YesNoFlag::NO,$execute_response);

        return response()->json($execute_response);
    }

    public function success(Request $request)
    {

        $id_token = $request->session()->get('id_token');
        $paymentID = $request->session()->get('paymentID');

        $transaction_id = $this->transaction_contact->get_temp_transaction_id();
        $query_response = $this->bkash_contact->query_payment($id_token,$paymentID);
        $this->log_contact->save_payment_log($transaction_id,PaymentConstant::QUERY_PAYMENT,YesNoFlag::NO,$query_response);


        $transaction_status = $query_response->transactionStatus;

        if($transaction_status == BkashConstant::COMPLETED_TRANSACTION_STATUS){

            $transaction_id = $this->transaction_contact->get_temp_transaction_id();

            $amount =  $this->transaction_contact->amount_from_selling_transaction($transaction_id);
            $product_order_id = TempTransaction::with([])->where('transaction_id','=',$transaction_id)->first()->product_order_id ;
            $resp = $this->transaction_contact->transaction_master_completed($transaction_id,$paymentID,Gateway::BKASH,$product_order_id,$amount);
            $this->log_contact->save_payment_log($transaction_id,PaymentConstant::SELLING_TRANSACTION_COMPLETED,YesNoFlag::YES,$resp);

            /*$mobile_no = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->mobile_number;
            $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;
            $message = 'Dear Sir, Your payment has been completed successfully. Your requested data is processing';
            $this->notification_contact->send_sms($customer_id,$mobile_no,$message);

            //SEND INVOICE MAIL
            //$product_order_id = 17;
            $product_order = ProductOrder::with([])->find($product_order_id);

            $product_order_details  = \DB::select("SELECT POD.PRODUCT_ORDER_ID , P.NAME, POD.PRICE ,FF.FILE_FORMAT_NAME

FROM PRODUCT_ORDER_DETAIL POD
LEFT JOIN PRODUCT_DETAIL PD
ON POD.PRODUCT_DETAIL_ID = PD.PRODUCT_DETAIL_ID
LEFT JOIN PRODUCT P
ON PD.PRODUCT_ID = P.PRODUCT_ID
LEFT JOIN L_FILE_FORMAT FF
ON PD.FILE_FORMAT_ID = FF.FILE_FORMAT_ID
WHERE POD.PRODUCT_ORDER_ID = ".$product_order_id);

            //$customer_id = 1;
            $customer = Customer::with([])->find($customer_id);

            $payment_method  ="Bkash";
            $transaction_reference  = $query_response->trxID;

            $to_name = $customer->email;
            $to_email = $customer->email;
            $data = array(
                "product_order"=>$product_order,
                "product_order_details"=>$product_order_details,
                "customer"=>$customer,
                "payment_method"=>$payment_method,
                "transaction_reference"=>$transaction_reference,
            );

            $app_name = config()->get('app.name');
            try{
                \Mail::send('emails.invoice', $data, function ($message) use ($to_name, $to_email, $app_name) {
                    $message->to($to_email, $to_name)
                        ->subject('Payment Invoice Mail');
                    $message->from(config('mail.from.address'), $app_name);
                });
            }catch (\Exception $e){

            }*/



            return view('payment.payment-success',[

                "product_order_id"=>$product_order_id
            ]);

        }

        return view('payment.payment-reject',[

            "product_order_id"=>null
        ]);

    }


}
