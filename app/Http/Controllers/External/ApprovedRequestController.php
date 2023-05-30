<?php

namespace App\Http\Controllers\External;

use App\Entities\Product\ProductOrder;
use App\Entities\Product\ProductOrderDetail;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

use App\Entities\Product\SellingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ApprovedRequestController extends Controller
{
    //
    public function index()
    {
        $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;

        $product_orders = ProductOrder::with('customer', 'product_order_detail','employee')
            ->where('confirmed_yn', '=', YesNoFlag::YES)
            ->where('payment_completed_yn', '!=', YesNoFlag::YES)
            ->where('customer_id' , '=' , $customer_id)
            ->orderBy('product_order_id', 'DESC')
            ->get();
        foreach ($product_orders as $product_order) {
            // code
            $product_order->product_order_details = ProductOrderDetail::with(['product', 'product_detail', 'file_format'])
                ->where('product_order_id', '=', $product_order->product_order_id)
                //->where('active_yn' , '=' , YesNoFlag::YES)
                ->get();

            // array_push($arr, $sp);
        }

        return view('external.approved-request-index', [
            'product_orders' => $product_orders
        ]);

        /*
        $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;
        $selling_requests = SellingRequest::with(['selling_product','file_format', 'customer'])->where('active_yn'  ,'=',
            YesNoFlag::YES)
            ->where('approved_yn' , '=' , YesNoFlag::YES)
            ->where('customer_id' , '=' , $customer_id)
            ->get();

        return view('external.selling-approved-request', [
            'selling_requests' => $selling_requests
        ]);*/
    }

    /*  public function product_approval_confirmation(Request $request,$id){
          $response = $this->save_product_approval($request,$id);
          return response()->json($response);
      }

      private function save_product_approval($request,$selling_request_id){
          $postData = $request->post();
          $procedure_name = 'SELLING_REQUEST_CONFIRMATION';
          try {
              $status_code = sprintf("%4000s","");
              $status_message = sprintf("%4000s","");

              $customer_id = '';
              $params = [
                  'I_SELLING_REQUEST_ID' => [
                      'value' => $selling_request_id
                  ],
                  'I_APPROVED_YN' => ($postData['approved_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                  'I_REMARKS' => $postData['remarks'],
                  'I_USER_ID' => auth()->id(),
                  'o_status_code' => &$status_code,
                  'o_status_message' => &$status_message,
              ];

              \DB::executeProcedure($procedure_name, $params);
          }
          catch (\Exception $e) {
              return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
          }

          return $params;
      }*/

    public function goto_payment_gateway(Request $request, $id)
    {


        $product_order_id = $id;

        $response = $this->temp_transaction_insert($product_order_id);
        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', $message);
            // return Redirect::back();
        }

        /*$response = $this->selling_transaction_insert($id);
        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            session()->flash('message', $message);
            return Redirect::back();
        }*/


        //        $message = 'Saved successfully.Please contract with authority for account activation';


        return redirect()->route('external-user.payment-index',['product_order_id'=> $id]);
    }

    private function temp_transaction_insert($product_order_id){
        // $postData = $request->post();
        $procedure_name = 'TEMP_TRANSACTION_INSERT';
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $transaction_id = sprintf("%4000s","");

            $customer_id = '';
            $params = [
                'I_PRODUCT_ORDER_ID' =>$product_order_id,
                'I_CUSTOMER_ID' => Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id,
                'o_transaction_id' => &$transaction_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


}
