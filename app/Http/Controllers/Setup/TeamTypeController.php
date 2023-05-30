<?php

namespace App\Http\Controllers\Setup;

use App\Entities\Setup\LTeamType;
use App\Entities\Setup\LZoneArea;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamTypeController extends Controller
{
    //
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('setup.team-type-index', [
            'teamType' => null
        ]);

        //return "ZoneAreaController";
    }


    public function edit(Request $request, $id)
    {
        $teamType = LTeamType::find($id);

        return view('setup.team-type-index', [
            'teamType' => $teamType
        ]);
    }

    public function dataTableList()
    {

        $queryResult = LTeamType::orderBy('team_type_id', 'DESC')->get();
        return datatables()->of($queryResult)
            ->addColumn('active', function($query) {
                $activeStatus = 'No';

                if($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function($query) {
                return '<a href="'. route('setup.team-type-edit', [$query->team_type_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function post(Request $request)
    {
        $response = $this->team_type_ins_upd($request,null);

        $message = $response['o_status_message'];

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.team-type-index');
    }


    public function update(Request $request,$id)
    {
        $response = $this->team_type_ins_upd($request, $id);

        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.team-type-index');
    }


/*CREATE OR REPLACE PROCEDURE HYDROAS.(
      IN NUMBER,
    IN VARCHAR2,
 IN VARCHAR2,

I_ACTIVE_YN        IN   VARCHAR2,
I_USER_ID          IN   NUMBER,
O_STATUS_CODE      OUT  NUMBER,
O_STATUS_MESSAGE   OUT  VARCHAR2)*/
    private function team_type_ins_upd(Request $request,$team_type_id)
    {
        $postData = $request->post();
        $procedure_name = 'TEAM_TYPE_INSERT';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_TEAM_TYPE_ID' => [
                    'value' => $team_type_id
                ],
                'I_TEAM_TYPE_NAME' => $postData['team_type_name'],
                'I_TEAM_TYPE_NAME_BN' => $postData['team_type_name_bn'],
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
