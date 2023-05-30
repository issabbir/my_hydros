<?php

namespace App\Http\Controllers\Schedule;

use App\Entities\Secdbms\Watchman\WorkFlowProcess;
use App\Entities\Secdbms\Watchman\WorkFlowStep;
use App\Entities\Security\Role;
use App\Entities\Security\SecUserRoles;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class WorkflowController extends Controller
{
    public function status(Request $request, $workflowId_out = null, $object_id_out = null)
    {
        if ($workflowId_out && $object_id_out) {
            $workflowId = $workflowId_out;
            $object_id = $object_id_out;
        } else {
            $workflowId = $request->get("workflowId");
            $object_id = $request->get("objectid");
        }
        $progressBarData = WorkFlowStep::where('approval_workflow_id', $workflowId)->orderby('process_step')->get();

        $current_step = [];
        $previous_step = [];
        $workflowProcess = WorkFlowProcess::with('workflowStep')
            ->where('workflow_object_id', $object_id)
            ->orderBy('workflow_process_id', 'DESC')
            ->whereHas('workflowStep', function ($query) use ($workflowId) {
                $query->where('approval_workflow_id', $workflowId);
            })->get();

        $option = [];
        if (!count($workflowProcess)) {
            $next_step = WorkFlowStep::where('approval_workflow_id', $workflowId)->orderBy('process_step', 'asc')->get();
        } else {
            if ($workflowProcess) {
                $current_step = $workflowProcess[0]->workflowStep;
                $sql = 'select e.emp_code, e.emp_name, d.designation
                       from cpa_security.sec_users u
                         inner join pmis.employee e on (e.emp_id = u.emp_id)
                         left join pmis.L_DESIGNATION d  on (d.designation_id = e.designation_id)
                         where user_id=:userId';
                $user = db::selectOne($sql, ['userId' => $workflowProcess[0]->insert_by]);
                $current_step->user = $user;
                $current_step->note = $workflowProcess[0]->note;
                $current_step->price_bdt = $workflowProcess[0]->price_bdt;
                $current_step->price_usd = $workflowProcess[0]->price_usd;
            }

            $next_step = WorkFlowStep::where('approval_workflow_id', $workflowId)->where('process_step', '>', $current_step->process_step)->orderBy('process_step', 'asc')->get();
            $previous_step = WorkFlowStep::where('approval_workflow_id', $workflowId)->where('process_step', '<', $current_step->process_step)->orderBy('process_step', 'asc')->get();
        }

        if (!empty($previous_step)) {
            foreach ($previous_step as $previous) {
                $option[] = [
                    'text' => "Backward " . $previous->workflow,
                    'value' => $previous->workflow_step_id,
                ];
            }
        }

        if (!empty($current_step)) {
            $option[] = [
                'text' => 'Forwarded ' . $current_step->workflow,
                'value' => $current_step->workflow_step_id,
                'disabled' => true
            ];
        }

        if (!empty($next_step)) {
            foreach ($next_step as $s) {
                $option[] = [
                    'text' => 'Forward ' . $s->workflow,
                    'value' => $s->workflow_step_id,
                ];
            }
        }


        $process = [];
        foreach ($workflowProcess as $wp) {
            $sql = 'select e.emp_code, e.emp_name, d.designation
                       from cpa_security.sec_users u
                         inner join pmis.employee e on (e.emp_id = u.emp_id)
                         left join pmis.L_DESIGNATION d  on (d.designation_id = e.designation_id)
                         where user_id=:userId';
            $user = db::selectOne($sql, ['userId' => $wp->insert_by]);
            $wp->user = $user;
            $process[] = $wp;
        }

        $msg = '';
        $ids = array_column($option, 'value');
        $value = $ids ? max($ids) : 0;
        $prev_val = $value;//dd($option);
        if (isset($previous_step) && !empty($previous_step)) {
            $select_data = WorkFlowStep::where('approval_workflow_id', $workflowId)->where('process_step', '>', $current_step->process_step)->orderBy('process_step', 'asc')->first();
        }
        if (isset($select_data) && !empty($select_data)) {
            $select_data = $select_data->workflow_step_id;
        } else {
            $select_data = $next_step[1]->workflow_step_id;
        }//dd($next_step);

        foreach ($option as $data) {
            $msg .= '<option value="' . $data['value'] . '"
            ' . (isset($select_data) && !empty($select_data) && $data['value'] == $select_data ? ' selected' : "") . '
            ' . ($data['value'] == 27 ? ' disabled' : "") . '
            ' . ($data['value'] == 33 ? ' disabled' : "") . '
            ' . ($data['value'] == 39 ? ' disabled' : "") . '
            ' . (isset($current_step->workflow_step_id) && !empty($current_step->workflow_step_id) && $data['value'] == $current_step->workflow_step_id ? ' disabled' : "") . '
            ' . ($data['value'] == 48 ? ' disabled' : "") . '>' . $data['text'] . '</option>';
        }
        $all_steps = WorkFlowStep::get();

        return response(
            [
                'workflowProcess' => $process,
                'progressBarData' => $progressBarData,
                'workflowSteps' => $all_steps,
                'next_step' => $next_step,
                'previous_step' => $previous_step,
                'current_step' => $current_step,
                'options' => $msg,
            ]
        );
    }

    public function store(Guard $auth, Request $request)
    {
        //dd($request->all());
        $postData = $request->post();
        if (isset($postData['final_approve_yn']) && $postData['final_approve_yn'] == 'Y' && $postData['bonus_id'] != null) {
            $status_id = $postData['bonus_id'];
        } else {
            $status_id = $postData['status_id'];
        }
        if (isset($postData['price_usd'])) {
            $note = $postData['price_bdt'] . ' ' . 'BDT' . ',' . ' ' . $postData['price_usd'] . ' ' . 'USD';
        } else {
            if (isset($postData['note'])) {
                $note = $postData['note'];
            } else {
                $note = '';
            }
        }
        $workflowId = $request->get("workflow_id");
        $object_id = $request->get("object_id");
        $getRole = WorkFlowStep::where('approval_workflow_id', $workflowId)->where('workflow_step_id', $status_id)->first();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_workflow_process_id" => $workflowId,
                "p_workflow_object_id" => $object_id,
                "p_workflow_step_id" => $status_id,
                "p_note" => $note,
                "p_bdt" => isset($postData['price_bdt']) ? $postData['price_bdt'] : '',
                "p_usd" => isset($postData['price_usd']) ? $postData['price_usd'] : '',
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            //dd($params);
            DB::executeProcedure("workflow_Process_entry", $params);

            if (!empty($getRole)) {
                if ($getRole->workflow_key != 'APPROVE') {

                    $role_id = Role::where('role_key', $getRole->workflow_key)->value('role_id');
                    $user_roles = SecUserRoles::where('role_id', $role_id)->get();
                    foreach ($user_roles as $user_role) {

                        $operator_notification = [
                            "p_notification_to" => $user_role->user_id,
                            "p_insert_by" => Auth::id(),
                            "p_note" => $note ? $note : 'You have notification. Please Check.',
                            "p_priority" => null,
                            "p_module_id" => 37,
                            "p_target_url" => isset($postData['get_url']) ? $postData['get_url'] : ''
                        ];
                        DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                    }
                }
            }

            if ($workflowId == '1') {
                if ($status_id == 27) {
                    /*$sql = 'select te.emp_id, te.email,emp.emp_name, sm.schedule_from_date, sm.schedule_to_date, su.USER_ID from team_employee te
left join schedule_assignment sa on (sa.team_id=te.team_id)
left join cpa_security.SEC_USERS su on (su.EMP_ID = te.EMP_ID)
left join schedule_master sm on (sm.schedule_master_id=sa.schedule_master_id)
left join pmis.employee emp on (emp.emp_id=te.emp_id)
where sa.schedule_master_id = :schedule_master_id';*/
                    $sql = 'select te.emp_id,
       te.email,
       emp.emp_name,
       sm.schedule_from_date,
       sm.schedule_to_date,
       sa.schedule_from_time,
       sa.schedule_to_time,
       su.user_id
  from team_employee  te
       left join schedule_assignment sa on (sa.team_id = te.team_id)
       left join cpa_security.sec_users su on (su.emp_id = te.emp_id)
       left join schedule_master sm
           on (sm.schedule_master_id = sa.schedule_master_id)
       left join pmis.employee emp on (emp.emp_id = te.emp_id)
 where sa.schedule_master_id = :schedule_master_id';
                    $user = db::select($sql, ['schedule_master_id' => $object_id]);
                    $email_verification_token = Str::random(32);

                    foreach ($user as $indx => $value) {
                        if ($value->email != '') {
                            $id = $value->emp_id;
                            $to_name = '';
                            $to_email = $value->email;

                            $data = array(
                                "name" => $value->emp_name,
                                "body" => "Schedule Confirmation mail",
                                "id" => $id,
                                "schedule_from_date" => date('d-m-Y', strtotime($value->schedule_from_date)),
                                "schedule_to_date" => date('d-m-Y', strtotime($value->schedule_to_date)),
                                "email_verification_token" => $email_verification_token
                            );

                            $app_name = config()->get('app.name');
                            \Mail::send('emails.schedule_confirmation', $data, function ($message) use ($to_name, $to_email, $app_name) {
                                $message->to($to_email, $to_name)
                                    ->subject('Schedule Confirmation mail');
                                $message->from(config('mail.from.address'), $app_name);
                            });
                        }

                        if ($value->user_id != '') {
                            $operator_notification = [
                                "p_notification_to" => $value->user_id,
                                "p_insert_by" => Auth::id(),
                                "p_note" => 'Your Schedule from ' . date('d-m-Y', strtotime($value->schedule_from_date)) . ' to ' . date('d-m-Y', strtotime($value->schedule_to_date)) . ' time ' . date('H:i', strtotime($value->schedule_from_time)) . ' to ' . date('H:i', strtotime($value->schedule_to_time)) . ' has been Approved',
                                /*"p_note" => 'Your Schedule from '.$value->schedule_from_date.' to '.$value->schedule_to_date.' has been Approved',*/
                                "p_priority" => null,
                                "p_module_id" => 37,
                                "p_target_url" => isset($postData['get_url']) ? $postData['get_url'] : ''
                            ];
                            DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                        }
                    }

                    $getAllRole = WorkFlowStep::where('approval_workflow_id', $workflowId)->get();

                    foreach ($getAllRole as $role) {
                        $role_id = Role::where('role_key', $role->user_role)->value('role_id');
                        $user_roles = SecUserRoles::where('role_id', $role_id)->get();
                        foreach ($user_roles as $user_role) {

                            $operator_notification = [
                                "p_notification_to" => $user_role->user_id,
                                "p_insert_by" => Auth::id(),
                                "p_note" => $note ? $note : 'You have notification. Please Check.',
                                "p_priority" => null,
                                "p_module_id" => 37,
                                "p_target_url" => isset($postData['get_url']) ? $postData['get_url'] : ''
                            ];
                            DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                        }
                    }
                }

                session()->flash('m-class', 'alert-success');
                session()->flash('message', $status_message);

                return redirect()->back()->with('message', $status_message);
            }
            if ($workflowId == '3') {
                session()->flash('m-class', 'alert-success');
                session()->flash('message', $status_message);

                return redirect()->back()->with('message', $status_message);
            }
            if ($workflowId == '4') {//dd($status_message);
                session()->flash('m-class', 'alert-success');
                session()->flash('message', $status_message);
                //return redirect()->route('schedule.reader-approval-index');
                return redirect('/schedule/reader-approval-index')->with('message', $status_message);
                //return redirect()->back()->with('message', $status_message);
            }
            if ($workflowId == '2') {
                if ($status_id == 33) {
                    $sql = 'select distinct su.user_id, v.vehicle_name from schedule_approval_dtl sad
left join boat_employee be on (be.boat_employee_id = sad.boat_employee_id)
left join cpa_security.sec_users su on (su.emp_id = be.emp_id)
left join schedule_approval_mst sam on (sad.schedule_mst_id = sam.schedule_mst_id)
left join vehicle v on (v.vehicle_id = sam.vehicle_id)
where sad.schedule_mst_id = :schedule_mst_id';
                    $user = db::select($sql, ['schedule_mst_id' => $object_id]);

                    foreach ($user as $indx => $value) {
                        if ($value->user_id != '') {
                            $operator_notification = [
                                "p_notification_to" => $value->user_id,
                                "p_insert_by" => Auth::id(),
                                "p_note" => 'You are selected for the boat named- ' . $value->vehicle_name,
                                "p_priority" => null,
                                "p_module_id" => 37,
                                "p_target_url" => null
                            ];
                            DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                        }
                    }
                }
                session()->flash('m-class', 'alert-success');
                session()->flash('message', $status_message);

                return redirect()->route('schedule.duty-roster-approval-index');
            }

        } catch (\Exception $e) {
            /*session()->flash('m-class', 'alert-danger');
            session()->flash('message', $status_message);

            return redirect()->back()->with('message', $status_message);*/
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
    }

    public function gpfFinalApprove($workflowId, $object_id, Guard $auth, Request $request)
    {

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_gpf_id" => $object_id,
                "p_gpf_status" => 'Y',
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pfprocess.gpf_application_approve", $params);
            if ($params['o_status_code'] == '1') {
                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
                $params = [
                    "p_workflow_process_id" => $request->get("workflow_process_id"),
                    "p_workflow_object_id" => $object_id,
                    "p_workflow_step_id" => $request->get("workflow_step_id"),
                    "p_note" => $request->get("note"),
                    "p_insert_by" => auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("workflow_Process_entry", $params);

                return $this->status($workflowId, $object_id);
            }
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }

}
