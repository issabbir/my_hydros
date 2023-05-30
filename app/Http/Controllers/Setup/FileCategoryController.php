<?php

namespace App\Http\Controllers\Setup;

use App\Entities\Setup\LFileCategory;
use App\Entities\Setup\LScheduleType;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileCategoryController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.file-category-index', [
            'fileCategory' => null
        ]);
    }


    public function edit(Request $request, $id)
    {
        $fileCategory = LFileCategory::find($id);

        return view('setup.file-category-index', [
            'fileCategory' => $fileCategory
        ]);
    }

    public function dataTableList()
    {
        $queryResult = LFileCategory::orderBy('file_category_id', 'DESC')->get();
        return datatables()->of($queryResult)
            ->addColumn('active', function($query) {
                $activeStatus = 'No';

                if($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function($query) {
                return '<a href="'. route('setup.file-category-edit', [$query->file_category_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function post(Request $request)
    {
        $response = $this->file_category_ins_upd($request,null);

        $message = $response['o_status_message'];

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.file-category-index');
    }


    public function update(Request $request,$id)
    {
        $response = $this->file_category_ins_upd($request, $id);

        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.file-category-index');
    }


    /*CREATE OR REPLACE PROCEDURE HYDROAS. (
            IN     NUMBER,
          IN     VARCHAR2,
       IN     VARCHAR2,
    I_ACTIVE_YN               IN     VARCHAR2,
    I_USER_ID                 IN     NUMBER,
    O_STATUS_CODE                OUT NUMBER,
    O_STATUS_MESSAGE             OUT VARCHAR2)*/
    private function file_category_ins_upd(Request $request,$file_category_id)
    {
        $postData = $request->post();
        $procedure_name = 'FILE_CATEGORY_INSERT';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_FILE_CATEGORY_ID' => [
                    'value' => $file_category_id
                ],
                'I_FILE_CATEGORY_NAME' => $postData['file_category_name'],
                'I_FILE_CATEGORY_NAME_BN' => $postData['file_category_name_bn'],
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
