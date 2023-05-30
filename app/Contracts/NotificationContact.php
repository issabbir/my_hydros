<?php
namespace App\Contracts;

interface NotificationContact{
    public function send_sms($user_id,$mobile,$message);
    public function send_email($transaction_id,$src_name,$completed_yn,$raw_data);
}
