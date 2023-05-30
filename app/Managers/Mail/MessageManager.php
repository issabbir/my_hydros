<?php

namespace App\Managers\Mail;

use App\Contracts\Mail\MessageContract;
use Illuminate\Support\Facades\Mail;

class MessageManager implements MessageContract
{
    /** @var string */
    private $url = '';

    /** @var string */
    private $user = '';

    /** @var string */
    private $password = '';

    private $from = null;

    /**
     * MessageManager constructor.
     */
    public function __construct()
    {
        $this->url = env('MESSAGE_BASE_URL', 'https://api.mobireach.com.bd/SendTextMessage');
        $this->user = env('MESSAGE_USER', 'cns');
        $this->password = env('MESSAGE_PASSWORD', 'Ikram*2017');
        $this->from = env('MESSAGE_FROM', '8801847169958');

        if (($this->url == '') || ($this->user == '') || ($this->password == '') || ($this->from == '')) {
            throw new \Exception('One or multiple required configuration(s) had not set yet to send sms.');
        }
    }

    /**
     * @param $to
     * @param $content
     * @return int|null
     */
    public function send($to, $content): ?int
    {
        $messageId = null;

        if (($to == '') || ($content == '')) {
            return null;
        }

        $url = $this->buildUrl($to, $content);
        if ($url) {
            try {
                $result = simplexml_load_file($url);
                $messageId = (int)$result->ServiceClass->MessageId[0]; // PHP 7 will work like this way but lower version "MAY" work like "$result[0]->MessageId".
            } catch (\Exception $exception) {
                $messageId = null;
            }
        }
        return $messageId;
    }

    /**
     * @param $to
     * @param $content
     * @return string
     */
    private function buildUrl($to, $content): string
    {
        return $this->url . '?Username=' . $this->user . '&Password=' . $this->password . '&From=' . $this->from . '&To=88' . $to . "&Message=" . urlencode($content);
    }

    public function sendMail($obj, $mail)
    {
        $status = true;
        if (count(Mail::failures()) > 0) {
            $status = false;
        } else {
            Mail::to($mail)->send($obj);
        }
        return $status;
    }

    /* public function queueMessages()
    {
        $processId = date('sihdmY') . rand(1, 999999);
        Message::where('email_send_status', null)
            ->where('try_counter', '<', 2)
            ->orWhere('email_send_status', 'R')
            ->orWhere('email_send_status', 'P')
            ->take(5)
            ->update(['email_send_status' => 'P', 'email_process_id' => $processId]);

        $messages = Message::where('email_process_id', $processId)->get();
        return $messages;
    } */

    /* public function sendSms()
    {
        return $this->getSMSReceivers();
    } */

    /* public function getSMSReceivers()
    {
        $messages = Message::where('SMS_SEND_STATUS', 'R')
            ->orWhereNull('SMS_SEND_STATUS')
            ->orWhere('SMS_SEND_STATUS', 'N')
            ->chunk(5, function ($message) {
                foreach ($message as $m) {
                    $m->update(['SMS_SEND_STATUS' => 'P']);
                    $smsBody = $this->getSMSBody($m);
                    $receiver = $m->receiver_mobile_no;
                    if ($smsBody) {
                        $msgStatus = $this->send($receiver, $smsBody);
                    } else {
                        $msgStatus = false;
                    }
                    if ($msgStatus) {
                        $m->update(['SMS_SEND_STATUS' => 'Y']);
                    } else {
                        $m->update(['SMS_SEND_STATUS' => 'N']);
                    }
                }
            });
    } */

    /* public function getSMSBody($m)
    {
        $msg = false;
        switch (strtoupper($m->message_type)) {
            case 'CM_VESSEL_MASTER_SMS':
//                $meeting = MeetingSetup::find($m->message_reference_id)->first();
//                $msg = 'Hi '.$m->receiver_name.'. A meeting on "'.$m->message_subject.'" has been called by '.$m->host_name.'. Thanks';
//                    .' The meeting will be held on '  .HelperClass::customDateTimeFormat($meeting->start_time).'. Thanks';
                $msg = $m->sms_body;
                break;
            default:
                break;

        }
        return $msg;
    } */

    /* public function processSMS($cellphone, $sms)
    {
        try {
//            $sms_send_url = env('SMS_BASE_URL')."&To=88" . $cellphone . "&Message=" . urlencode($sms);
            $sms_send_url = "https://api.mobireach.com.bd/SendTextMessage?Username=cns&Password=Ikram*2017&From=8801847169958&To=88" . $cellphone . "&Message=" . urlencode($sms);
            $return_msg = simplexml_load_file($sms_send_url);
//            $response = (int) $return_msg[0]->MessageId;
            $response = true;
        } catch (\Exception $e) {
            $response = false;
        }
        return $response;
    } */
}
