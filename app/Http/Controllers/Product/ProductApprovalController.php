<?php

namespace App\Http\Controllers\Product;

use App\Contracts\NotificationContact;
use App\Entities\Product\Customer;
use App\Entities\Product\ProductOrder;
use App\Entities\Product\ProductOrderDetail;
use App\Entities\Product\SellingRequest;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductApprovalController extends Controller
{
    private $notification_contact;


    public function __construct(NotificationContact $notification_contact)
    {
        $this->notification_contact = $notification_contact;
    }

    public function index()
    {
        $getKey = json_encode(Auth::user()->roles->pluck('role_key'));
        $getKey = json_decode($getKey, true);

        $product_orders = ProductOrder::with('customer', 'product_order_detail','employee')
            ->where('confirmed_yn', '=', YesNoFlag::NO)->orderBy('PRODUCT_ORDER_ID', 'DESC')
            ->whereIn('user_role', $getKey)
            ->get();
        foreach ($product_orders as $product_order) {
            // code
            $product_order->product_order_details = ProductOrderDetail::with(['product', 'product_detail', 'file_format'])
                ->where('product_order_id', '=', $product_order->product_order_id)
                //->where('active_yn' , '=' , YesNoFlag::YES)
                ->get();

            // array_push($arr, $sp);
        }

        return view('product.product-approval-index', [
            'product_orders' => $product_orders
        ]);
    }

    public function update(Request $request)
    {

        $product_order_detail_id = $request->get('product_order_detail_id');
        $postData = $request->post();
        $price  = $postData['price'];
        $response = $this->save_product_approval($request, $product_order_detail_id,$price);
        return response()->json($response);
    }


    public function product_approval_confirmation(Request $request)
    {

        $product_order_id = $request->get('product_order_id');
        $product_order = ProductOrder::with(['product_order_detail'])->find($product_order_id);


        $product_order_details = $request->get('product_order_details');

        foreach ($product_order_details as $product_order_detail){
            $product_order_detail_id = $product_order_detail["product_order_detail_id"];
           // $postData = $request->post();
            $price  = $product_order_detail["price"];
            $response = $this->save_product_approval( $product_order_detail_id,$price);

            if($response['o_status_code'] != '1'){
                return response()->json($response);
            };
        }

        $customer_id = $product_order->customer_id;
        $customer = Customer::with([])->find($customer_id);
        $mobile = $customer->mobile_number;

        $total = 0;

        $product_order_details = ProductOrderDetail::with([])
            ->where('product_order_id', '=', $product_order->product_order_id)
            ->get();

        foreach ($product_order_details as $item){

            $total += $item->price;

        }


        if($total <= 0){

            $message = "Total price can not be zero.Please set price of all item!";


            $obj = array();
            $obj['o_status_code'] = '0';
            $obj['o_status_message'] = $message;
            return response()->json($obj);

        }

        $payment_amount = $total;



        $message = "Purchase Request confirmed successfully";

        $response = $this->save_product_order_confirmation($request,$product_order_id);

        if($response['o_status_code'] != '1'){
            return response()->json($response);
        };


        $response['o_status_message'] = $message;

        $message = "Your requested order no. " . $product_order_id .
            " is approved.Please pay " . $payment_amount . " BDT .Please visit the hydrography portal to make payment . \n Thanks Hydrography dept.";
        $this->notification_contact->send_sms(auth()->id(), $mobile, $message);



        return response()->json($response);
    }

    public function product_approval_rejection(Request $request)
    {

        $product_order_id = $request->get('product_order_id');
        $product_order = ProductOrder::with(['product_order_detail'])->find($product_order_id);


        $customer_id = $product_order->customer_id;
        $customer = Customer::with([])->find($customer_id);
        $mobile = $customer->mobile_number;

        $message = "Your requested order no. " . $product_order_id .
            " is rejected. \n Thanks Hydrography dept.";
        $this->notification_contact->send_sms(auth()->id(), $mobile, $message);

        $message = "Purchase Request rejected";

        $response = $this->save_product_order_confirmation($request,$product_order_id);

        if($response['o_status_code'] != '1'){
            return response()->json($response);
        };


        $response['o_status_message'] = $message;


        return response()->json($response);
    }

    private function save_product_approval($selling_request_id,$price)
    {
        //$postData = $request->post();
        $procedure_name = 'PRODUCT_APPROVAL_CONFIRMATION';
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $customer_id = '';
            $params = [
                'I_PRODUCT_DETAIL_ID' => [
                    'value' => $selling_request_id
                ],
                'I_PRICE' => $price,
                'I_USER_ID' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    /*CREATE OR REPLACE PROCEDURE HYDROAS.(
     IN NUMBER,
         IN VARCHAR2,
         IN NUMBER,

    O_STATUS_CODE     OUT NUMBER,
    O_STATUS_MESSAGE  OUT VARCHAR2)*/


    private function save_product_order_confirmation($request, $product_order_id)
    {
        $postData = $request->post();
        $procedure_name = 'PRODUCT_ORDER_CONFIRMATION';
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $customer_id = '';
            $params = [
                'I_PRODUCT_ORDER_ID' => [
                    'value' => $product_order_id
                ],
                'I_CONFIRMED_YN' => $postData['confirmed_yn'],
                'I_CONFRIMED_BY' => auth()->user()->emp_id,
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
