<?php

namespace App\Http\Controllers\Setup;

use App\Entities\Product\Product;
use App\Entities\Product\ProductDetail;
use App\Entities\Setup\LFileFormat;
use App\Entities\Setup\LTeamType;
use App\Entities\Setup\Team;
use App\Entities\Setup\TeamEmployee;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductFormatController extends Controller
{
    //


    public function index(Request $request)
    {
        $product_id = $request->session()->get('product_id','');
       // $request->session()->forget('product_id');
        $products = Product::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        return view('setup.product-format-index', [
            'product_detail' => null,
            'products' => $products,
            'product' => Product::with([])->find($product_id),
            'file_formats' =>  LFileFormat::with([])->where('active_yn','=',YesNoFlag::YES)->get()
        ]);

    }

    public function edit(Request $request, $id)
    {
        $product_detail = ProductDetail::with(['product','file_format'])->find($id);
        $products = Product::with([])->where('active_yn','=',YesNoFlag::YES)->get();
        return view('setup.product-format-index', [
            'product_detail' => $product_detail,
            'products' => $products,
            'product' => $product_detail->product,
            'file_formats' =>  LFileFormat::with([])->where('active_yn','=',YesNoFlag::YES)->get()
        ]);
    }

    public function dataTableList(Request $request)
    {
        $product_id = $request->get('id');
        $queryResult = ProductDetail::with(['product','file_format'])
            ->where('product_id','=',$product_id)
            ->orderBy('product_detail_id', 'DESC')->get();

        return datatables()->of($queryResult)
            ->addColumn('active', function($query) {
                $activeStatus = 'No';

                if($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function($query) {
                return '<a href="'. route('setup.product-format-edit', [$query->product_detail_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function post(Request $request)
    {
        $response = $this->product_detail_ins_upd($request,null);

        $message = $response['o_status_message'];

        $request->session()->put('product_id',$request->get('product_id'));

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.product-format-index');
    }


    public function update(Request $request,$id)
    {
        //dd($request->all());
        //dd($id);
        $response = $this->product_detail_ins_upd($request, $id);
        // dd($response);

        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        $request->session()->put('product_id',$request->get('product_id'));

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.product-format-index');
    }
    /*CREATE OR REPLACE PROCEDURE HYDROAS. (
       IN     NUMBER,
              IN     VARCHAR2,
          IN     VARCHAR2,
                   IN     NUMBER,
    I_ACTIVE_YN           IN     VARCHAR2,
    I_USER_ID             IN     NUMBER,
    O_STATUS_CODE            OUT NUMBER,
    O_STATUS_MESSAGE         OUT VARCHAR2)*/
    private function product_detail_ins_upd(Request $request,$product_detail_id)
    {
        $postData = $request->post();
        $procedure_name = 'PRODUCT_DETAIL_INSERT';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_PRODUCT_DETAIL_ID' => [
                    'value' => $product_detail_id,
                    'type' => \PDO::PARAM_INT
                ],
                'I_PRODUCT_ID' => $postData['product_id'],
                'I_FILE_FORMAT_ID' => $postData['file_format_id'],
                'I_PRICE' => $postData['price'],
                'I_ACTIVE_YN' => ($postData['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
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
    }
}
