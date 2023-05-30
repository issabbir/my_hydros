<?php

namespace App\Http\Controllers\Setup;

use App\Entities\Product\Product;
use App\Entities\Product\SellingProduct;
use App\Entities\Setup\LFileCategory;
use App\Enums\ProjectModule;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $info = [
            'product' => null,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
        ];
        return view('setup.product-index', $info);
    }

    public function dataTableList()
    {

        $queryResult = Product::with(['file_category'])->orderBy('product_id', 'DESC')->get();
        return datatables()->of($queryResult)
            ->addColumn('active', function ($query) {
                $activeStatus = 'No';

                if ($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function ($query) {
                return '<a href="' . route('setup.product-edit', [$query->product_id]) . '"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
    }


    private function file_ins_upd($file, $file_category_id, $file_info_id)
    {
        $procedure_name = 'FILE_UPLOAD_INSERT';
        // $procedure_name = 'FILE_UPLOAD_INSERT_BACK';

        try {

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
                'I_FILE_TITLE' => $fileName,
                'I_FILE_CATEGORY_ID' => $file_category_id,
                'I_FILE_FORMAT_ID' => 1,
                'I_SURVEY_SOFTWARE_ID' => 1,
                'I_ACTIVE_YN' => YesNoFlag::YES,
                'I_MODULE_ID' => ProjectModule::PRODUCT_SELL_ID,
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

    public function post(Request $request)
    {
        /* $file_info_id = null;

         $upload_file = $request->get('upload_file');
         $file_category_id = $request->get('file_category_id');

         if($upload_file){

             $file = $upload_file;

             $response = $this->file_ins_upd($file,$file_category_id,null);

             if($response['o_status_code'] == 1){
                 $file_info_id = $response['I_FILE_INFO_ID'];
             }
         }*/

        $response = $this->product_ins_upd($request, null);

        $message = $response['o_status_message'];

        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.product-index');
    }


    public function update(Request $request, $id)
    {
        $response = $this->product_ins_upd($request, $id);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.product-index');
    }

    private function product_ins_upd(Request $request, $product_id)
    {
        $postData = $request->post();
        $procedure_name = 'PRODUCT_INSERT_TEST_File_UP';

        try {

            $file = $request->file('upload_file');
            if (isset($file)) {
                $fileName = $file->getClientOriginalName();
                $fileType = $file->getMimeType();
                $fileContent = base64_encode(file_get_contents($file->getRealPath()));
            }

           else {
                $fileName = null;
                $fileType = null;
                $fileContent = null;
            }


            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'I_PRODUCT_ID' => [
                    'value' => $product_id
                ],
                'I_NAME' => $postData['name'],
                'I_NAME_BN' => $postData['name_bn'],
                'I_DESCRIPTION' => $postData['description'],
                'I_FILE_CATEGORY_ID' => $postData['file_category_id'],
                'I_FILE_NAME' => $fileName,
                'I_FILE_TYPE' => $fileType,
                'I_FILE_CONTENT' => [
                    'value' => $fileContent,
                    'type' => \PDO::PARAM_LOB,
                    //'length'  => strlen($fileContent)
                ],
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


    public function edit(Request $request, $id)
    {
        $product = Product::with(['file_category', 'file_info'])->find($id);

        $info = [
            'product' => $product,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
        ];


        return view('setup.product-index', $info);

    }


}
