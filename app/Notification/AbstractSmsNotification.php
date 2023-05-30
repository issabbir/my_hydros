<?php
/**
 * Created by PhpStorm.
 * User: MOU
 * Date: 16-Jul-20
 * Time: 12:34 PM
 */


namespace App\Notification;

abstract class AbstractSmsNotification {
    public abstract function send_sms($mobile,$message);

    protected function build_sms($mobile,$message){
        $encoded_string = e($message);
        $url = 'https://api.mobireach.com.bd/SendTextMessage?Username=cns&Password=Ikram*2017&From=8801847169958&To='.$mobile.'&Message=' . $encoded_string;
        return $url;

    }

    protected function send_and_return_response($url){
        $client = new \GuzzleHttp\Client();
        $request = $client->get($url);
        $response = $request->getBody();
        return $response;
    }

    protected function log_sms($response){

    }
}