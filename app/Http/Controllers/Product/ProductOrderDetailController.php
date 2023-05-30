<?php

namespace App\Http\Controllers\Product;

use App\Entities\File\FileInfo;
use App\Entities\Product\Customer;
use App\Entities\Product\Product;
use App\Entities\Product\productOrderDelivered;

use App\Entities\Product\ProductOrder;
use App\Entities\Product\ProductOrderDetail;
use App\Entities\Product\ProductOrderDetailFile;
use App\Entities\Product\SellingRequest;
use App\Entities\Product\SellingRequestDetail;
use App\Entities\Setup\LFileCategory;
use App\Entities\Setup\LFileFormat;
use App\Entities\Setup\LSurveySoftware;
use App\Enums\ProjectModule;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductOrderDetailController extends Controller
{
    public function uploaded_file_list(Request $request){/*
        $product_order_detail_id = $request->get('product_order_detail_id');
        $product_order_detail_files = $this->product_order_detail_file_list($product_order_detail_id);
        return response()->json($product_order_detail_files);*/
        //$product_order_detail_id = $request->get('product_order_detail_id');
        $product_order_detail_id = $request->get('id');
        /* $file_info_list = ProductOrderDetailFile::with([])
             ->where('product_order_detail_id' ,'=',$product_order_detail_id)
             ->get(['file_info_id'])->toArray();
         $queryResult = FileInfo::with(['file_category','employee'])
             ->whereIn('file_info_id', $file_info_list)
             ->orderBy('file_info_id', 'DESC')->get();

         //product_order_detail_id
         foreach ($queryResult as $file) {
             // code
             $file->product_order_detail_id = $product_order_detail_id;

         }*/

       $queryResult = ProductOrderDetailFile::with('file_info')
           ->where('product_order_detail_id' ,'=',$product_order_detail_id)
           ->get();

        foreach ($queryResult as $podf) {
            // code

            $file_info = FileInfo::with(['file_category','employee'])
                ->find( $podf->file_info_id);
            $emp_name = '';
            if(isset($file_info->employee)){
                $emp_name = $file_info->employee->emp_name;
            }
            $podf->emp_name = $emp_name;
            $podf->file_name = $file_info->file_name;
            $podf->insert_time = $file_info->insert_time;

        }


        return datatables()->of($queryResult)
            /*->addColumn('active', function ($query) {
                $activeStatus = 'No';

                if ($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })*/
            ->addColumn('emp_name', function ($query) {
                $emp_name = '';

                if (isset($query->employee)) {
                    $emp_name = $query->employee->emp_name;
                }

                return $emp_name;
            })
            ->addColumn('action', function ($query) {
                $resp =  '<a target="_blank" href="' . route('file.file-upload-download', [$query->file_info_id]) . '"><i class="bx bx-download cursor-pointer"></i></a>';
                $resp = $resp . " | ".
                    '<a href="' . route('product.delete_product_order_detail', [$query->product_order_detail_file_id]) . '"><i class="bx bx-trash cursor-pointer"></i></a>';
                return $resp;
            })
            ->addIndexColumn()
            ->make(true);
    }

    private function product_order_detail_file_list($product_order_detail_id){
        $product_order_detail_files = ProductOrderDetailFile::with(['file_info','employee'])
            ->where('product_order_detail_id' ,'=',$product_order_detail_id)
            ->get();

        foreach ($product_order_detail_files as $item) {
            $item->download_link = route('file.file-upload-download', [$item->file_info_id]);
        }
    }

    public function detail(Request $request,$id)
    {//dd($id);
        $product_order_details = ProductOrderDetail::with('product', 'product_detail', 'product_order_detail_file')
            ->where('product_order_id', '=', $id)
            ->get();

        foreach ($product_order_details as $product_order_detail) {
            if(isset($product_order_detail->product_detail)){
                $product_order_detail->file_format = LFileFormat::find($product_order_detail->product_detail->file_format_id);
                $product_order_detail->product_name = Product::where('product_id',$product_order_detail->product_id)->pluck('name')[0];
            }

        }
      //  $product_order_detail_id = $request->session()->get('product_order_detail_id',null);
        //$request->session()->forget('product_order_detail_id');

        $product_order = ProductOrder::with('customer', 'product_order_detail')->find($id);

        return view('product.product-upload-order-detail', [
            'product_order_details' => $product_order_details,
            'product_order_id' => $id,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
            'surveySoftwares' => LSurveySoftware::where('active_yn', YesNoFlag::YES)->get(),
            'fileFormats' => LFileFormat::with([])->where('active_yn', '=', YesNoFlag::YES)->orderBy('file_format_id', 'ASC')->get(),
            'product_order_detail_id' => null,
            'product_order' =>$product_order
        ]);
    }

    public function post(Request $request, $id)
    {
        $product_order_detail_id = $request->get('product_order_detail_id');
        $response = $this->save_uploaded_file($request, $product_order_detail_id);

        $message = $response['o_status_message'];

        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

       // $request->session()->put('product_order_detail_id',$product_order_detail_id);

        return redirect()->route('product.product-order-detail',[$id]);
    }

    private function save_uploaded_file($request, $product_order_detail_id)
    {
        $postData = $request->post();

        $procedure_name = 'ORDER_DETAIL_FILE_INSERT';
        //$procedure_name = 'SELLING_REQUEST_DETAIL_BACK';
        try {

            $file = $request->file('upload_file');

            if (!$file) {
                throw new \Exception('File not found!');
            }

            $fileName = $file->getClientOriginalName();
            $fileType = $file->getMimeType();
            $fileContent = base64_encode(file_get_contents($file->getRealPath()));


            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $selling_request_detail_id = '';

            $customer_id = '';
            $params = [
                'I_PRODUCT_ORDER_DETAIL_FILE_ID' => [
                    'value' => &$selling_request_detail_id,
                    'type' => \PDO::PARAM_INT,
                ],
                'I_PRODUCT_ORDER_DETAIL_ID' => $product_order_detail_id,
                'I_FILE_NAME' => $fileName,
                'I_FILE_TYPE' => $fileType,
                'I_FILE_CONTENT' => [
                    'value' => $fileContent,
                    'type' => \PDO::PARAM_LOB,
                    //'length'  => strlen($fileContent)
                ],
                'I_UPLOADED_BY' => auth()->user()->emp_id,
                'I_ACTIVE_YN' => ($postData['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
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

    public function customer_detail_with_order(Request $request){
        $customer_id = $request->get('customer_id');

        $customer = Customer::with([])
            ->find($customer_id);

        $product_order_id = $request->get('product_order_id');

        $product_order= \DB::select("SELECT POD.PRODUCT_ORDER_ID , P.NAME, PD.PRICE ,FF.FILE_FORMAT_NAME

FROM PRODUCT_ORDER_DETAIL POD
LEFT JOIN PRODUCT_DETAIL PD
ON POD.PRODUCT_DETAIL_ID = PD.PRODUCT_DETAIL_ID
LEFT JOIN PRODUCT P
ON PD.PRODUCT_ID = P.PRODUCT_ID
LEFT JOIN L_FILE_FORMAT FF
ON PD.FILE_FORMAT_ID = FF.FILE_FORMAT_ID
WHERE POD.PRODUCT_ORDER_ID = ".$product_order_id);

        $obj = array();
        $obj['customer'] = $customer;
        $obj['product_order'] = $product_order;

        return response()->json($obj);
    }

    public function delete_product_order_detail(Request $request,$id){
        $product_order_detail_file = ProductOrderDetailFile::with([])->find($id);
        if($product_order_detail_file){
            $product_order_detail_file->delete();
        }


        session()->flash('m-class', 'alert-danger');
        session()->flash('message', 'Product deleted successfully');

        $product_order_detail_id =$product_order_detail_file->product_order_detail_id;

        $product_order_detail = ProductOrderDetail::with([])->find($product_order_detail_id);

        $product_order_id = $product_order_detail->product_order_id;

        return redirect()->route('product.product-order-detail',[$product_order_id]);


    }

    public function post_file(Request $request)
    {
        $response = $this->file_ins_upd($request, null);

        $message = $response['o_status_message'];

        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        //return redirect()->route('file.product-order-detail');
        return redirect('/product/product-order-detail/' . $request->get("product_order_id"));

    }

    private function file_ins_upd(Request $request, $file_info_id)
    {
        $postData = $request->post();
        $procedure_name = 'FILE_UPLOAD_INSERT';
        // $procedure_name = 'FILE_UPLOAD_INSERT_BACK';

        try {
            $file = $request->file('upload_file');

            if (!$file) {
                throw new \Exception('File not found!');
            }

            $fileName = $file->getClientOriginalName();
            $fileType = $file->getMimeType();
            $fileContent = base64_encode(file_get_contents($file->getRealPath()));

            // $fileContentStr = json_encode( $fileContent, JSON_UNESCAPED_SLASHES);

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            //   $file_info_id = '';

            $params = [
                'I_FILE_INFO_ID' => [
                    'value' => &$file_info_id,
                    'type' => \PDO::PARAM_INT,
                ],
                'I_FILE_TITLE' => $postData['file_title'],
                'I_FILE_CATEGORY_ID' => $postData['file_category_id'],
                'I_FILE_FORMAT_ID' => $postData['file_format_id'],
                'I_SURVEY_SOFTWARE_ID' => $postData['survey_software_id'],
                'I_ACTIVE_YN' => ($postData['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_MODULE_ID' => ProjectModule::FILE_ID,
                'I_FILE_NAME' => $fileName,
                'I_FILE_TYPE' => $fileType,
                'I_FILE_CONTENT' => [
                    'value' => $fileContent,
                    'type' => \PDO::PARAM_LOB,
                    //'length'  => strlen($fileContent)
                ],
                'I_UPLOADED_BY' => auth()->user()->emp_id,
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

    public function archive_index()
    {

        $info = [
            'fileInfo' => null,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
            'surveySoftwares' => LSurveySoftware::where('active_yn', YesNoFlag::YES)->get(),
            'fileFormats' => LFileFormat::with([])->where('active_yn', '=', YesNoFlag::YES)->orderBy('file_format_id', 'ASC')->get(),
        ];

        return view('file.archive-search-index', $info);
    }

    public function archive_post(Request $request)
    {//dd($request);

        $file_category_id = $request->get('file_category_id');
        $file_name=$request->get('file_name');
        $file_from_date = $request->get('file_from_date');
        $file_to_date = $request->get('file_to_date');

        /*   $response = $this->file_ins_upd($request, null);

           $message = $response['o_status_message'];

           if ($response['o_status_code'] != 1) {
               session()->flash('m-class', 'alert-danger');
               return redirect()->back()->with('message', $message);
           }*/


        $queryResult = [];


        if ($file_category_id || $file_name ) {

            $queryResult = FileInfo::with(['file_category','employee'])
                ->where('file_category_id', '=', $file_category_id)
                ->orWhere('file_name','LIKE', '%' . $file_name . '%')
                ->whereDate('insert_time', '>=', $file_from_date)
                ->whereDate('insert_time', '<=', $file_to_date)
                ->where('module_id', '=', ProjectModule::FILE_ID)
                ->orderBy('file_info_id', 'DESC')->get();

        }else{

            $queryResult = FileInfo::with(['file_category', 'employee'])
                // ->where('file_category_id', '=', $file_category_id)
                ->whereDate('insert_time', '>=', $file_from_date)
                ->whereDate('insert_time', '<=', $file_to_date)
                ->where('module_id', '=', ProjectModule::FILE_ID)
                ->orderBy('file_info_id', 'DESC')->get();


        }


        $message = "Got " . count($queryResult) . " file from search";


        $fileInfo = new FileInfo();
        $fileInfo->file_category_id = $file_category_id;
        $fileInfo->file_name=$file_name;
        $fileInfo->file_from_date = $file_from_date;
        $fileInfo->file_to_date = $file_to_date;

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        $info = [
            'fileInfo' => $fileInfo,
            'fileInfoes' => $queryResult,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
            'surveySoftwares' => LSurveySoftware::where('active_yn', YesNoFlag::YES)->get(),
            'fileFormats' => LFileFormat::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
        ];

        return redirect()->route('/product/product-order-detail/'. $request->get("product_order_id"), ['info' => $info]);
        //return view('product.product-upload-order-detail', $info);
    }

    public function multi_post(Request $request)
    {
        //dd($request->all());

        $lastParams = [];
        DB::beginTransaction();

        try {

            foreach ($request->get('selected') as $indx => $value) {
                $selected = $request->get('selected')[$indx];
                $result = explode('-', $selected);
                $product_order_detail_id = $result[1];
                $file_info_id = $result[0];
                $params = [];

                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
                $params = [
                    "p_product_order_detail_id" => $product_order_detail_id,
                    "p_file_info_id" => $file_info_id,
                    "p_uploaded_by" => auth()->user()->emp_id,
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message
                ];

                DB::executeProcedure("HYDROAS.product_order_detail_file_ins", $params);
                $lastParams = $params;

                if ($params['o_status_code'] != 1) {
                    DB::rollBack();
                    $params['html'] = view('product.message')->with('params', $params)->render();
                }

                DB::commit();
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return ["exception" => true, "o_status_code" => false, "o_status_message" => $exception->getMessage()];
        }
        $lastParams['html'] = view('product.message')->with('params', $lastParams)->render();
        return $lastParams;
    }

    public function dataTableList(Request $request)
    {//dd($request->all());

        $file_category_id = $request->get('file_category_id');
        $file_name=$request->get('file_name');
        $file_from_date = $request->get('file_from_date');
        $file_to_date = $request->get('file_to_date');
        $product_id = $request->get('product_id');

        $queryResult = [];


        if ($file_category_id || $file_name ) {

            $queryResult = FileInfo::with(['file_category','employee'])
                ->where('file_category_id', '=', $file_category_id)
                ->orWhere('file_name','LIKE', '%' . $file_name . '%')
                ->whereDate('insert_time', '>=', $file_from_date)
                ->whereDate('insert_time', '<=', $file_to_date)
                ->where('module_id', '=', ProjectModule::FILE_ID)
                ->orderBy('file_info_id', 'DESC')->get();

        }else{

            $queryResult = FileInfo::with(['file_category', 'employee'])
                // ->where('file_category_id', '=', $file_category_id)
                ->whereDate('insert_time', '>=', $file_from_date)
                ->whereDate('insert_time', '<=', $file_to_date)
                ->where('module_id', '=', ProjectModule::FILE_ID)
                ->orderBy('file_info_id', 'DESC')->get();


        }
        foreach ($queryResult as $query) {
            $query->product_order_detail_id = $product_id;
        }
//dd($queryResult->all());
        /*$queryResult = FileInfo::with(['file_category','employee'])
            ->where('module_id', '=', ProjectModule::FILE_ID)
            ->orderBy('file_info_id', 'DESC')->get();*/

        return datatables()->of($queryResult)
            ->addColumn('selected', function ($query) {
                $param = $query->file_info_id.'-'.$query->product_order_detail_id;
                $html = <<<HTML
<input type="hidden" name="file_info_id[]" value="{$query->file_info_id}" />
<input type="checkbox" name="selected[]" value="{$param}"/>
HTML;
                return $html;
            })
            ->addColumn('active', function ($query) {
                $activeStatus = 'No';

                if ($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })->addColumn('emp_name', function ($query) {
                $emp_name = '';

                if ($query->employee) {
                    $emp_name = $query->employee->emp_name;
                }

                return $emp_name;
            })
            ->addColumn('action', function ($query) {
                return '<a target="_blank" href="' . route('file.file-upload-download', [$query->file_info_id]) . '"><i class="bx bx-download cursor-pointer"></i></a>';
            })->rawColumns(['selected'])
            ->addIndexColumn()
            ->make(true);
    }

}
