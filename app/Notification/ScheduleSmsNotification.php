<?php
/**
 * Created by PhpStorm.
 * User: MOU
 * Date: 16-Jul-20
 * Time: 12:18 PM
 */
namespace App\Notification;

class ScheduleSmsNotification extends AbstractSmsNotification {

    public function send_sms($mobile, $message)
    {
        //build SMS
        $url = $this->build_sms($mobile,$message);
        //Send Sms
        $response = $this->send_and_return_response($url);
        //Log sms
        $this->log_sms($response);
    }


}