<?php

namespace App\Http\Controllers;

use App\Entities\Product\Customer;
use App\Entities\Schedule\Schedule;
use App\Entities\Security\GenNotifications;
use App\Enums\YesNoFlag;
use App\Entities\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;
use PDO;
use App\Helpers\CommonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function index()
    {

        return view('user.login');
    }

    public function dashboard()
    {

        $vw_dashboard_count = DB::table('vw_dashboard_count')->get();
        $vw_recent_payment = DB::table('vw_recent_payment')->get();

        $approved_schedules = Schedule::with('schedule_type')
            ->where('approved_yn', '=', YesNoFlag::YES)
            ->orderBy('schedule_master_id', 'DESC')
            ->take(5)
            ->get();

        $haydros_notifications= DB:: select("select HN.HYDRO_NOTIFICATION_ID, HN.MESSAGE from  HYDRO_NOTIFICATION HN where HN.SEEN_YN= 'N'");
//dd($haydros_notifications);

        return view('dashboard.index', [
                'vw_recent_payment' => $vw_recent_payment,
                'vw_dashboard_count' => $vw_dashboard_count,
                'approved_schedules' => $approved_schedules,
                'hydros_notification'=>$haydros_notifications,
            ]

        );

    }


    public function notification_seen(Request $request){
        $hydro_notification_id = $request->get('hydro_notification_id');
        return $this->notification_ins_upd($request,$hydro_notification_id);
    }

    private function notification_ins_upd(Request $request,$hydro_notification_id)
    {
        $postData = $request->post();
        $procedure_name = 'HYDRO_NOTIFICATION_INS_UPD';

        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                'I_HYDRO_NOTIFICATION_ID' => [
                    'value' => $hydro_notification_id
                ],
                'I_NOTIFICATION_SRC' => '',
                'I_MESSAGE' => "",
                'I_MODULE_ID'=>'1',
                'I_SEEN_YN' => 'Y',
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

    function updateNotification(Request $request){
        if($request->get("notification_id")){
            $result = GenNotifications::where('notification_id', $request->get("notification_id"))->update(['seen_yn' => 'Y']);
        }
    }

}
