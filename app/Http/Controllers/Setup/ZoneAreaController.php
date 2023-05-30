<?php

namespace App\Http\Controllers\Setup;

use App\Entities\Setup\LZoneArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Enums\YesNoFlag;
use Illuminate\Support\Facades\DB;

class ZoneAreaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('setup.zone-area-index', [
            'zoneArea' => null
        ]);

        //return "ZoneAreaController";
    }


    public function edit(Request $request, $id)
    {
        $zoneArea = LZoneArea::find($id);

        return view('setup.zone-area-index', [
            'zoneArea' => $zoneArea
        ]);
    }

    public function dataTableList()
    {

        $queryResult = LZoneArea::orderBy('zonearea_id', 'DESC')->get();
        return datatables()->of($queryResult)
            ->addColumn('active', function($query) {
                $activeStatus = 'No';

                if($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function($query) {
                return '<a href="'. route('setup.zone-area-edit', [$query->zonearea_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function post(Request $request)
    {
        $response = $this->zone_area_ins_upd($request,null);

        $message = $response['o_status_message'];

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.zone-area-index');
    }


    public function update(Request $request,$id)
    {
        $response = $this->zone_area_ins_upd($request, $id);

        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.zone-area-index');
    }

    private function zone_area_ins_upd(Request $request,$zonearea_id)
    {
        $postData = $request->post();
        $procedure_name = 'ZONEAREA_INSERT';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_ZONEAREA_ID' => [
                    'value' => $zonearea_id
                ],
                'I_SHEET_NO' => $postData['sheet_no'],
                'I_PROPOSED_NAME' => $postData['proposed_name'],
                'I_PROPOSED_NAME_BN' => $postData['proposed_name_bn'],
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
