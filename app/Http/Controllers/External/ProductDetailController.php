<?php

namespace App\Http\Controllers\External;

use App\Entities\Product\Product;
use App\Entities\Product\ProductDetail;
use App\Entities\Setup\LFileFormat;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    //
    public function index($id)
    {

        $product = Product::with(['file_category'])->find($id);
       // dd($product->product_detail);
        $product_details = ProductDetail::with('file_format','file_info')
            ->where('active_yn','=',YesNoFlag::YES)
            ->where('product_id',$id)
            ->orderBy('price', 'ASC')
            ->get();



       // $products = Product::with(['file_category'])->where('active_yn','=',YesNoFlag::YES)->get();
        return view('external.product-detail',[
            "product" => $product,
            "product_details" => $product_details,

            "fileFormats" => LFileFormat::with([])->get()
        ]);
    }
    //Call by dashboard modal
    public function product_detail_by_id(Request $request){
        $product_id = $request->product_id;

        $product = Product::with([])->find($product_id);

        return response()->json($product);
    }
}
