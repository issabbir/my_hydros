<?php

namespace App\Http\Controllers\Schedule;

use App\Contracts\LogContact;
use App\Contracts\NotificationContact;
use App\Contracts\Payment\BkashContact;
use App\Contracts\Transaction\TransactionContact;
use App\Entities\Setup\LNotificationType;
use App\Entities\Setup\LScheduleType;
use App\Entities\Setup\LZoneArea;
use App\Entities\Schedule\Schedule;
use App\Entities\Setup\Team;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleNotificationController extends Controller
{
    private $notification_contact;

    public function __construct(NotificationContact $notification_contact)
    {
        $this->notification_contact = $notification_contact;
    }
    //
    public function index(Request $request)
    {
        //schedule_master_id
        $approved_schedule = Schedule::with(['schedule_type'])
            ->where('approved_yn', '=', YesNoFlag::YES)
            ->orderBy('schedule_master_id', 'DESC')
            ->get();

        $notification_types = LNotificationType::with([])->get();
        return view('schedule.schedule-notification-index', [
            'approved_schedules' => $approved_schedule,
            'notification_types' => $notification_types,
        ]);
    }

    public function dataTableList()
    {

        $queryResult = Schedule::with(['notification_type'])
            ->where('approved_yn', '=', YesNoFlag::YES)
            ->orderBy('schedule_master_id', 'DESC')
            ->get();
        return datatables()->of($queryResult)
            ->addColumn('notified', function($query) {
                $activeStatus = 'No';

                if($query->notified_yn == YesNoFlag::YES) {
                    $activeStatus = 'Yes';
                }

                return $activeStatus;
            })->addColumn('notification_type_name', function($query) {
                $notification_type_name = '';

                if($query->notification_type) {
                    $notification_type_name = $query->notification_type->notification_type_name;
                }

                return $notification_type_name;
            })

            /*
            ->addColumn('action', function($query) {
                return '<a href="'. route('setup.schedule-type-edit', [$query->schedule_type_id]) .'"><i class="bx bx-edit cursor-pointer"></i></a>';
            })*/
            ->addIndexColumn()
            ->make(true);
    }


    public function post(Request $request)
    {
        $schedule_master_id = $request->get('schedule_master_id');
        $notification_type_id = $request->get('notification_type_id');

        $schedule = Schedule::with([])->find($schedule_master_id);

        $details = DB::select("SELECT T.TEAM_ID , MOBILE_NO,EMAIL 
FROM TEAM T
LEFT JOIN TEAM_EMPLOYEE TE ON T.TEAM_ID = TE.TEAM_ID
WHERE T.TEAM_ID IN (
SELECT TEAM_ID FROM SCHEDULE_ASSIGNMENT  WHERE SCHEDULE_MASTER_ID = $schedule_master_id)");

        foreach ($details as $detail){

            $sms_message = " Your schedule from $schedule->schedule_from_date to $schedule->schedule_to_date has been approved.";
            $email_message = " Your schedule from $schedule->schedule_from_date to $schedule->schedule_to_date has been approved.";

            if($notification_type_id == "1" || $notification_type_id == "3"){

                $mobile_no = $detail->mobile_no;
                if(isset($mobile_no) && strlen($mobile_no) == 11){

                    $this->notification_contact->send_sms(1,$mobile_no,$sms_message);
                }
            }


            if($notification_type_id == "2" || $notification_type_id == "3"){

               // $email_from = $detail->email;
                $to_name = $detail->email;
                $to_email = $detail->email;
                $app_name = config()->get('app.name');

                $data = array(
                    "email_message"=>$email_message,
                );

                if(isset($to_name)){

                    try{
                        \Mail::send('emails.schedule_notification', $data, function ($message) use ($to_name, $to_email, $app_name) {
                            $message->to($to_name, $to_email)
                                ->subject('Schedule Notification');
                            $message->from(config('mail.from.address'), $app_name);
                        });
                    }catch (\Exception $e){

                    }


                }

            }

        }


        $response = $this->schedule_notification_ins_upd($request,$schedule_master_id);

        $message = $response['o_status_message'];

        if($response['o_status_code'] != 1) {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message);
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('schedule.schedule-notification-index');
    }

    private function schedule_notification_ins_upd(Request $request,$schedule_master_id)
    {
        $postData = $request->post();
        $procedure_name = 'SCHEDULE_NOTIFICATION';

        try {
            //$zonearea_id = null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_SCHEDULE_MASTER_ID' => [
                    'value' => $schedule_master_id
                ],
                'I_NOTIFICATION_TYPE_ID' => $postData['notification_type_id'],
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
