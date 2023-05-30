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

class ProductUploadController extends Controller
{

    private $notification_contact;


    public function __construct(NotificationContact $notification_contact)
    {
        $this->notification_contact = $notification_contact;
    }

    public function index()
    {
        $product_orders = ProductOrder::with('customer', 'product_order_detail')
            ->where('payment_completed_yn', '=', YesNoFlag::YES)
            ->where('notified_yn', '=', YesNoFlag::YES)
            ->orderBy('product_order_id','DESC')
            ->get();

        return view('product.product-upload-index', [
            'product_orders' => $product_orders
        ]);
    }

     public function file_upload_confirmation(Request $request)
     {
         $product_order_id = $request->get('product_order_id');
         $product_order = ProductOrder::with([])->find($product_order_id);

         if (!$product_order) {
             $message = 'Product order not found!';
             $obj = array();
             $obj['o_status_code'] = '0';
             $obj['o_status_message'] = $message;
             return response()->json($obj);
         }

         if ($product_order->confirmed_yn != 'Y') {
             $message = 'Can not notify before confirmation';
             $obj = array();
             $obj['o_status_code'] = '0';
             $obj['o_status_message'] = $message;
             return response()->json($obj);
         }
         $file_upload_complete_yn = $request->get('file_upload_complete_yn') == YesNoFlag::YES ? YesNoFlag::YES : YesNoFlag::NO;

         $response = $this->confirmation_update( $product_order_id,$file_upload_complete_yn);

         if ($response['o_status_code'] != 1) {
             return response()->json($response);
         }

         $customer_id = $product_order->customer_id;
         $customer = Customer::with([])->find($customer_id);
         // $mobile = '01719461643';
         $mobile = $customer->mobile_number;
         $message = "Your order no. " . $product_order_id .
             " is complete.Please visit the portal to download the file. \n Thanks Hydrography dept.";
         $this->notification_contact->send_sms(auth()->id(), $mobile, $message);
         return response()->json($response);
     }

     private function confirmation_update($product_order_id,$file_upload_complete_yn)
     {
         $procedure_name = 'P_ORDER_CONFIRMATION_UPDATE';

         try {
             $status_code = sprintf("%4000s", "");
             $status_message = sprintf("%4000s", "");

             $params = [
                 'I_PRODUCT_ORDER_ID' => [
                     'value' => $product_order_id
                 ],
                 'I_FILE_UPLOAD_COMPLETE_YN' => $file_upload_complete_yn,
                 'I_USER_ID' => auth()->user()->emp_id,
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
