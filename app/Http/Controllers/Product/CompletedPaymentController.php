<?php

namespace App\Http\Controllers\Product;

use App\Contracts\LogContact;
use App\Contracts\NotificationContact;
use App\Contracts\Payment\BkashContact;
use App\Contracts\Transaction\TransactionContact;
use App\Entities\Product\Customer;
use App\Entities\Product\ProductOrder;
use App\Entities\Product\ProductOrderDetail;
use App\Entities\Product\SellingRequest;
use App\Entities\Product\SellingRequestDetail;
use App\Entities\Setup\LZoneArea;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompletedPaymentController extends Controller
{

    private $notification_contact;


    public function __construct(NotificationContact $notification_contact)
    {
        $this->notification_contact = $notification_contact;
    }

    //
    public function index()
    {
        /*   //$customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;
           $selling_requests = SellingRequest::with(['selling_product', 'file_format', 'customer', 'selling_request_details'])
               ->where('payment_completed_yn', '=', YesNoFlag::YES)
               ->get();*/


        $product_orders = ProductOrder::with('customer', 'product_order_detail')
            ->where('payment_completed_yn', '=', YesNoFlag::YES)
            ->orderBy('product_order_id','DESC')
            ->get();


        /*foreach ($product_orders as $product_order) {
            // code
            $po->product_order_detail = ProductOrderDetail::with(['product','product_detail'])
                ->where('product_order_id' ,'=',$po->product_order_id)
                //->where('active_yn' , '=' , YesNoFlag::YES)
                ->get();

            // array_push($arr, $sp);
        }*/
        return view('product.completed-payment-index', [
            'product_orders' => $product_orders
        ]);
    }

    public function product_confirm_notify(Request $request)
    {
        $product_order_id = $request->get('product_order_id');
        $tentative_confirmation = $request->get('tentative_confirmation');
        $notified_yn = ($request->get('notified_yn') == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO;

        $product_order = ProductOrder::with([])->find($product_order_id);

        if (!$product_order) {
            $message = 'Product order not found!';
            $obj = "";
            $obj->o_status_code = '0';
            $obj->o_status_message = $message;
            return response()->json($obj);
        }


        $response = $this->product_order_notification_update( $product_order_id,$tentative_confirmation,$notified_yn);

        if ($response['o_status_code'] != 1) {
            return response()->json($response);
        }

        $customer_id = $product_order->customer_id;
        $customer = Customer::with([])->find($customer_id);
        // $mobile = '01719461643';
        $mobile = $customer->mobile_number;
        $message = "Your order no. " . $product_order_id .
            " is confirmed and tentative delivery date is " . $tentative_confirmation. " \n Thanks Hydrography dept.";
        $this->notification_contact->send_sms(auth()->id(), $mobile, $message);
        return response()->json($response);
    }

    /*CompletedPaymentController*/
    private function product_order_notification_update($product_order_id,$tentative_confirmation,$notified_yn)
    {
        $procedure_name = 'P_ORDER_NOTIFICATION_UPDATE';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            //$tentative_delivery_date = $postData['tentative_delivery_date'];
            $params = [
                'I_PRODUCT_ORDER_ID' => [
                    'value' => $product_order_id
                ],
                'I_TENTATIVE_CONFIRMATION' => $tentative_confirmation,
                'I_NOTIFIED_YN' => $notified_yn,
                'I_NOTIFIED_BY' => auth()->user()->emp_id,
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
