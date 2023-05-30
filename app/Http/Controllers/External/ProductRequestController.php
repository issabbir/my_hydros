<?php

namespace App\Http\Controllers\External;

use App\Entities\Product\ProductOrder;
use App\Entities\Product\ProductOrderDetail;
use App\Entities\Product\SellingProduct;
use App\Entities\Product\SellingRequest;
use App\Entities\Setup\LFileCategory;
use App\Entities\Setup\LFileFormat;
use App\Enums\YesNoFlag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class ProductRequestController extends Controller
{

    protected $productContact ;
    //
    public function index(Request $request)
    {

        $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;

        $product_orders = ProductOrder::with('customer', 'product_order_detail','employee')
            ->where('confirmed_yn', '!=', YesNoFlag::YES)
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

        return view('external.product-request-index', [
            'product_orders' => $product_orders
        ]);
    }


    public function dataTableList()
    {

        $queryResult = ProductOrder::with('customer', 'product_order_detail')
           // ->where('payment_completed_yn', '=', YesNoFlag::YES)
            ->get();


        return datatables()->of($queryResult)
            ->addColumn('active', function($query) {
                $activeStatus = 'No';

                if($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
           /* ->addColumn('action', function($query) {
                return '<a href="'. route('external-user.selling-request-edit', [$query->selling_request_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })*/
            ->addIndexColumn()
            ->make(true);
    }

    public function post(Request $request)
    {
        $response = $this->selling_request_ins_upd($request,null);


        //return response()->json($response);

        $message = $response['o_status_message'];

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('external-user.selling-request-index');
    }


    public function update(Request $request,$id)
    {
        $response = $this->selling_request_ins_upd($request, $id);

        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.zone-area-index');
    }
    private function selling_request_ins_upd(Request $request,$selling_request_id)
    {
        $postData = $request->post();
        $procedure_name = 'SELLING_REQUEST_INSERT';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $tentative_delivery_date = $postData['tentative_delivery_date'];
            $params = [
                'I_SELLING_REQUEST_ID' => [
                    'value' => $selling_request_id
                ],
                'I_REQUEST_DESCRIPTION' => $postData['request_description'],
                'I_SELLING_PRODUCT_ID' => $postData['selling_product_id'],
                'I_FILE_FORMAT_ID' => $postData['file_format_id'],
                'I_TENTATIVE_DELIVERY_DATE' =>  $tentative_delivery_date,
                'I_PRODUCT_QTY' => $postData['product_qty'],

                'I_ACTIVE_YN' => ($postData['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_CUSTOMER_ID' => Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->id(),

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

    public function selling_product_by_id(Request $request){
        $id = $request->get('selling_product_id');
        $sellingProduct = SellingProduct::with([ 'file_category'])->find($id);
        return response()->json($sellingProduct);
    }

    public function edit(Request $request, $id)
    {
        $sellingRequest = SellingRequest::with([])->find($id);
        $info = [
            'sellingRequest' => $sellingRequest,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
            'sellingProducts' => SellingProduct::with([ 'file_category'])->where('active_yn','=',YesNoFlag::YES)->get(),
            'fileFormats' => LFileFormat::with([])->where('active_yn','=',YesNoFlag::YES)->get()
        ];


        return view('external.selling-request-index', $info);

    }
}
