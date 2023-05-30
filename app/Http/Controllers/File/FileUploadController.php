<?php

namespace App\Http\Controllers\File;

use App\Entities\File\FileInfo;
use App\Entities\Product\SellingProduct;
use App\Entities\Setup\LFileCategory;
use App\Entities\Setup\LFileFormat;
use App\Entities\Setup\LSurveySoftware;
use App\Enums\ProjectModule;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileUploadController extends Controller
{
    public function index()
    {

        $info = [
            'fileInfo' => null,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
            'surveySoftwares' => LSurveySoftware::where('active_yn', YesNoFlag::YES)->get(),
            'fileFormats' => LFileFormat::with([])->where('active_yn', '=', YesNoFlag::YES)->get(),
        ];

        return view('file.file-upload-index', $info);
    }


    public function post(Request $request)
    {
        $response = $this->file_ins_upd($request, null);

        $message = $response['o_status_message'];

        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('file.file-upload-index');
    }

    public function dataTableList()
    {

        $queryResult = FileInfo::with(['file_category','employee'])
            ->where('module_id', '=', ProjectModule::FILE_ID)
            ->orderBy('file_info_id', 'DESC')->get();

        return datatables()->of($queryResult)
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
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function download(Request $request, $id)
    {
        // $result = FileInfo::find($id, ['file_name', 'file_type','file_content']);

        $result = DB::table('file_info')
            ->where('file_info_id', '=', $id)
            ->select(array('file_name', 'file_type', 'file_content'))
            ->first();
        // return response()->json($result);

        //$file_contents = substr(substr(strval($result->file_content), 1), 0, -1);
        // $file_contents = strval($result->file_content);
        /*
                return response($file_contents)
                    ->header('Cache-Control', 'no-cache private')
                    ->header('Content-Description', 'File Transfer')
                    ->header('Content-Type', $result->file_type)
                    ->header('Content-length', strlen($file_contents))
                    ->header('Content-Disposition', 'attachment; filename=' . $result->file_name);*/

        //if($result->file_type == 'image/png'){
        $path = public_path($result->file_name);
        $contents = base64_decode($result->file_content);

//store file temporarily
        file_put_contents($path, $contents);

//download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);

        //}
        /*  return view('file.file-download', [
              'result' => $result
          ]);*/

        //return response()->attachment($result->file_name, $result->file_type, $file_contents);

    }

    /*

        public function update(Request $request,$id)
        {
            $response = $this->selling_product_ins_upd($request, $id);

            $message = $response['o_status_message'];
            if($response['o_status_code'] != 1) {
                session()->flash('m-class', 'alert-danger');
                return redirect()->back()->with('message', $message);
            }

            session()->flash('m-class', 'alert-success');
            session()->flash('message', $message);

            return redirect()->route('setup.selling-product-index');
        }*/

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


    public function edit(Request $request, $id)
    {
        $sellingProduct = SellingProduct::with(['file_category'])->find($id);

        $info = [
            'sellingProduct' => $sellingProduct,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
        ];


        return view('setup.selling-product-index', $info);

    }


}
