<?php

namespace App\Http\Controllers\External;

use App\Entities\Product\Product;
use App\Entities\Product\ProductOrder;
use App\Entities\Product\ProductOrderDetail;
use App\Entities\Product\ProductOrderDetailFile;
use App\Entities\Product\SellingProduct;
use App\Entities\Product\SellingRequest;
use App\Entities\Product\SellingRequestDetail;
use App\Entities\Setup\LFileCategory;
use App\Entities\Setup\LFileFormat;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductDownloadController extends Controller
{
    //
    //
    public function index()
    {
        $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;
        $product_orders = ProductOrder::with('customer','product_order_detail')
            ->where('payment_completed_yn' , '=' , YesNoFlag::YES)
            ->where('notified_yn' , '=' , YesNoFlag::YES)
            ->where('file_upload_complete_yn' , '=' , YesNoFlag::YES)

            ->where('customer_id' , '=' , $customer_id)
            ->orderBy('product_order_id', 'DESC')
            ->get();

        foreach ($product_orders as $product_order) {
            // code
            $product_order->product_order_details = DB::select("SELECT PODF.PRODUCT_ORDER_DETAIL_FILE_ID,FI.FILE_INFO_ID,P.NAME,P.DESCRIPTION,FF.FILE_FORMAT_NAME,FI.FILE_NAME,PODF.PRODUCT_ORDER_DETAIL_FILE_ID,PODF.UPLOADED_BY,VE.EMP_NAME
FROM PRODUCT_ORDER_DETAIL POD
LEFT JOIN PRODUCT P ON POD.PRODUCT_ID = P.PRODUCT_ID
LEFT JOIN PRODUCT_ORDER_DETAIL_FILE PODF ON POD.PRODUCT_ORDER_DETAIL_ID = PODF.PRODUCT_ORDER_DETAIL_ID
LEFT JOIN V_EMPLOYEE VE ON VE.EMP_ID = PODF.UPLOADED_BY
LEFT JOIN L_FILE_FORMAT FF ON FF.FILE_FORMAT_ID = POD.FILE_FORMAT_ID
LEFT JOIN FILE_INFO FI ON FI.FILE_INFO_ID = PODF.FILE_INFO_ID
WHERE PRODUCT_ORDER_ID =".$product_order->product_order_id);

            // array_push($arr, $sp);
        }
        return view('external.product-download-index', [
            'product_orders' => $product_orders
        ]);
    }


    public function detail($id)
    {

        $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;

        $product_order = ProductOrder::with([])->find($id);

        if(!$product_order){
            $message = 'Product order not found!';
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        if($product_order->customer_id != $customer_id){
            $message = 'You are not authorize to view page!';
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        $product_order_details = ProductOrderDetail::with('product', 'product_detail', 'product_order_detail_file')
            ->where('product_order_id', '=', $id)
         //   ->where('customer_id' , '=' , $customer_id)
            ->orderBy('product_order_id', 'DESC')
            ->get();

        foreach ($product_order_details as $product_order_detail) {
            // code
            $product_order_detail->file_format = LFileFormat::find($product_order_detail->product_detail->file_format_id);
            $product_order_detail->product_order_detail_files =
                ProductOrderDetailFile::with(["employee","file_info"])
                 ->where('product_order_detail_id' , '=' , $product_order_detail->product_order_detail_id)
                ->get();
            //->get();

            // array_push($arr, $sp);
        }

        return view('external.product-download-order-detail', [
            'product_order_details' => $product_order_details,
            'product_order_id' => $id

        ]);

    }
    public function download(Request $request, $id)
    {
        $result = DB::table('file_info')
            ->where('file_info_id', '=', $id)
            ->select(array('file_name', 'file_type', 'file_content'))
            ->first();

        $path = public_path($result->file_name);
        $contents = base64_decode($result->file_content);
        file_put_contents($path, $contents);

        return response()->download($path)->deleteFileAfterSend(false);
    }

}
