<?php

namespace App\Http\Controllers\Setup;

use App\Entities\Schedule\GadgeStationDtl;
use App\Entities\Schedule\GadgeStationList;
use App\Entities\Schedule\GadgeStationMst;
use App\Entities\Schedule\GadgeStationOffday;
use App\Entities\Schedule\GadgeStationShift;
use App\Entities\Secdbms\Watchman\WorkFlowStep;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ShiftSetupController extends Controller
{
    public function index()
    {
        return view('schedule.shift-setup');
    }

    public function dataTableList()
    {
        $queryResult = GadgeStationShift::all();
        return datatables()->of($queryResult)
            ->addColumn('shift_from_time', function ($query) {
                if ($query->shift_from_time != null) {
                    return Carbon::parse($query->shift_from_time)->format('H:i');
                } else {
                    return '--';
                }

            })
            ->addColumn('shift_to_time', function ($query) {
                if ($query->shift_to_time != null) {
                    return Carbon::parse($query->shift_to_time)->format('H:i');
                } else {
                    return '--';
                }

            })
            ->addColumn('action', function ($query) {
                //$actionBtn = '<a title="Edit" href="' . route('schedule.shift-setup-edit', [$query->shift_id]) . '"><i class="bx bx-edit cursor-pointer"></i></a>';
                $actionBtn = ' <a data-pilotageid="' . $query->shift_id . '" class="text-primary removeData"><i class="bx bx-trash cursor-pointer"></i></a>';
                return $actionBtn;

            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function edit(Request $request, $id)
    {
        $data = GadgeStationShift::select('*')
            ->where('shift_id', '=', $id)
            ->first();

        return view('schedule.shift-setup', [
            'data' => $data,
        ]);
    }

    public function post(Request $request)
    {
        $response = $this->ins_upd($request);
        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.shift-setup-index');
    }

    public function update(Request $request)
    {
        $response = $this->ins_upd($request);

        $message = $response['o_status_message'];
        if ($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', 'error|' . $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.shift-setup-index');
    }

    private function ins_upd(Request $request)
    {//dd($request);

        $postData = $request->post();
        if (isset($postData['shift_id'])) {
            $shift_id = $postData['shift_id'];
        } else {
            $shift_id = '';
        }
        try {
            DB::beginTransaction();
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'p_SHIFT_ID' => $shift_id,
                'p_SHIFT_FROM_TIME' => $postData['shift_from_time'],
                'p_SHIFT_TO_TIME' => $postData['shift_to_time'],
                'P_INSERT_BY' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];//dd($params);
            DB::executeProcedure('HYDROAS.L_GAUGE_STATION_SHIFT_IU', $params);

            if ($params['o_status_code'] != 1) {
                DB::rollBack();
                return $params;
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function removeData(Request $request)
    {
        try {
            GadgeStationShift::where('shift_id', $request->get("row_id"))->delete();
            return '1';
        } catch (\Exception $e) {
            DB::rollBack();
            return '0';
        }

    }
}
