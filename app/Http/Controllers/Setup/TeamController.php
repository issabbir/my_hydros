<?php

namespace App\Http\Controllers\Setup;

use App\Entities\Setup\LTeamType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Setup\Team;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    public function index(Request $request,$id=null)
    {
        return view('setup.team-index', [
            'team' => null,
            'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),
            'team_id' => $id,
        ]);

    }


    public function edit(Request $request, $id)
    {
        $team = Team::find($id);

        return view('setup.team-index', [
            'team' => $team,
            'teamTypes' => LTeamType::with([])->where('active_yn','=',YesNoFlag::YES)->get(),
            'team_id' => $id,

        ]);
    }

    public function dataTableList()
    {
        $queryResult = Team::orderBy('team_id', 'DESC')->get();
        return datatables()->of($queryResult)
            ->addColumn('active', function($query) {
                $activeStatus = 'No';

                if($query->active_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })
            ->addColumn('action', function($query) {
                return '<a href="'. route('setup.team-edit', [$query->team_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function post(Request $request)
    {
        $team_id = null;
        $response = $this->team_ins_upd($request,$team_id);

        $message = $response['o_status_message'];

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        $team_id = $response['o_team_id'];
        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.team-index',['id' => $team_id]);
    }


    public function update(Request $request,$id)
    {
        //dd($request->all());
        //dd($id);
        $response = $this->team_ins_upd($request, $id);
       // dd($response);

        $message = $response['o_status_message'];
        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('setup.team-index',['id' => $id]);
    }
    private function team_ins_upd(Request $request,$team_id)
    {
        $postData = $request->post();
        $procedure_name = 'TEAM_INSERT';

        try {
            //$zonearea_id = null;
            $o_team_id = sprintf("%4000s","");
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_TEAM_ID' => [
                    'value' => $team_id
                ],
                'I_TEAM_NAME' => $postData['team_name'],
                'I_TEAM_NAME_BN' => $postData['team_name_bn'],
                'I_TEAM_DESCRIPTION' => $postData['team_description'],
                'I_TEAM_FORMATION_DATE' => $postData['team_formation_date'],
                'I_TEAM_TERMINATION_DATE' => $postData['team_termination_date'],

                'I_TEAM_TYPE_ID' => $postData['team_type_id'],
                'I_ACTIVE_YN' => ($postData['active_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_USER_ID' => auth()->id(),
                'o_team_id' => &$o_team_id,
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
