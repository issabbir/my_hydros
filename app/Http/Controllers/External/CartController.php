<?php

namespace App\Http\Controllers\External;

use App\Entities\Product\Product;
use App\Entities\Product\ProductDetail;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
//use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

//https://github.com/darryldecode/laravelshoppingcart
class CartController extends Controller
{
    //
    /*
        public function index()
        {

            $products = Product::all();
            return response()->json($products);
        }

        public function shop()
        {
            $products = Product::all();
            // dd($products);
            return view('shop')->withTitle('E-COMMERCE STORE | SHOP')->with(['products' => $products]);
        }*/

    public function cart()
    {
        $cartCollection = \Cart::getContent();
        //dd($cartCollection);
        return view('external.cart')->withTitle('HYDROGRAPHY E-COMMERCE STORE | CART')->with(['cartCollection' => $cartCollection]);;
    }


    public function add(Request $request)
    {
        //dd($request->all());

        $product_detail_id = $request->id;
        $product = DB::select("SELECT FI.FILE_TYPE , FI.FILE_CONTENT
FROM PRODUCT_DETAIL PD
JOIN PRODUCT P
ON PD.PRODUCT_ID  = P.PRODUCT_ID
LEFT JOIN FILE_INFO FI
ON Fi.FILE_INFO_ID = P.FILE_INFO_ID
WHERE PD.PRODUCT_DETAIL_ID = $product_detail_id");
        $file_type = null;
        $file_content = null;

        if(isset($product) && count($product) > 0){
            $file_type = $product[0]->file_type;
            $file_content = $product[0]->file_content;
        }


        /*$cartCollection = \Cart::getContent();

// NOTE: Because cart collection extends Laravel's Collection
// You can use methods you already know about Laravel's Collection
// See some of its method below:

// count carts contents
        $cartCollection->count();*/

        $cart_item = array(
            'id' => \Cart::getContent()->count() + 1,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,

            'attributes' => array(
                'file_type' => $file_type,
                'file_content' => $file_content,
                'image' => $request->img,
                'slug' => $request->slug,
                'product_id' => $request->id ,
                'file_format_name' => $request->file_format_name,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
            )
        );
        \Cart::add(
            $cart_item
        );
        return redirect()->route('external-user.cart')->with('success_msg', 'Item is Added to Cart!');

      //  return 'ok';

    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);
        return redirect()->route('external-user.cart')->with('success_msg', 'Item is removed!');
    }

    public function update(Request $request)
    {
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ));
        return redirect()->route('external-user.dashboard')->with('success_msg', 'Cart is Updated!');
    }

    public function clear()
    {
        \Cart::clear();
        return redirect()->route('external-user.dashboard')->with('success_msg', 'Car is cleared!');
    }

    public function checkout(Request $request)
    {
        /*        $cartCollection = \Cart::getContent();

                dd($cartCollection);*/

        $items = \Cart::getContent();

        $message_code = '';
        $message = '';

        DB::beginTransaction();
        try {

            $response = $this->product_order_insert();
            $message = $response['o_status_message'];
            if ($response['o_status_code'] != 1) {
                throw new \Exception($response['o_status_message']);
            }

            $product_order_id = $response['o_product_order_id'];
            foreach ($items as $row) {
                $product_detail_id = $row->attributes->product_id;
                $from_date = $row->attributes->from_date;
                $to_date = $row->attributes->to_date;
                $quantity = $row->quantity;

                $response = $this->product_order_detail_insert($product_order_id,$product_detail_id,$from_date,$to_date,$quantity);

                if ($response['o_status_code'] != 1) {
                    throw new \Exception($response['o_status_message']);
                }

            }
            $message_code = $response['o_status_code'];
        } catch (\Exception $e) {
            DB::rollback();
            $message_code = 0;
            $message = $e->getMessage();
            // return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            // return redirect()->route('external-user.cart')->with('success_msg',  $e->getMessage());
        }

        if($message_code != 1){
            return redirect()->route('external-user.cart')->with('success_msg',  $message);
        }
        DB::commit();
        \Cart::clear();

        session()->flash('m-class', 'alert-success');
        session()->flash('message', "Request submitted successfully");


        return redirect()->route('external-user.product-request-index');
    }

    private function product_order_insert()
    {
        // $postData = $request->post();
        $procedure_name = 'PRODUCT_ORDER_INSERT';
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $product_order_id = sprintf("%4000s", "");

            //  $customer_id = '';
            $params = [
                'I_CUSTOMER_ID' => Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id,
                'o_product_order_id' => &$product_order_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    private function product_order_detail_insert($product_order_id, $product_detail_id,$from_date,$to_date,$quantity)
    {
        // $postData = $request->post();
        $procedure_name = 'PRODUCT_ORDER_DETAIL_INSERT';
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            //  $product_order_id = sprintf("%4000s","");

            //  $customer_id = '';
            $params = [
                'I_PRODUCT_ORDER_ID' => $product_order_id,
                'I_PRODUCT_DETAIL_ID' => $product_detail_id,
                'I_FROM_DATE' => $from_date,
                'I_TO_DATE' => $to_date,
                'I_CUSTOMER_ID' => Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id,
                //'o_product_order_id' => &$product_order_id,
                'I_qty'=>$quantity,
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
