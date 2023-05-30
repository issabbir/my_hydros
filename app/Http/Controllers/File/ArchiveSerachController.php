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

class ArchiveSerachController extends Controller
{
    public function index()
    {

        $info = [
            'fileInfo' => null,
            'fileCategories' => LFileCategory::where('active_yn', YesNoFlag::YES)->get(),
            'surveySoftwares' => LSurveySoftware::where('active_yn', YesNoFlag::YES)->get(),
            'fileFormats' => LFileFormat::with([])->where('active_yn', '=', YesNoFlag::YES)->orderBy('file_format_id', 'ASC')->get(),
        ];

        return view('file.archive-search-index', $info);
    }


    public function post(Request $request)
    {

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

        return view('file.archive-search-index', $info);
    }
}
