<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    //

    public function index(){
        $proxy ="";
        $proxyauth ="";
        $postDatatoken = '{
"password": "123456Aa",
"userName": "test"
}';
        $serviceUrltoken ="";
        $serviceUrltoken= 'https://sandbox.thecitybank.com:7788/transaction/token';
        $cblcz = $this->ProcessRequest($postDatatoken,$serviceUrltoken,$proxy,$proxyauth);


        $transactionId = $cblcz['transactionId'];
//print_r($cblcz);
//exit();

        $serviceUrlEcomm = 'https://sandbox.thecitybank.com:7788/transaction/createorder';

        $curl = curl_init();

        $postdataEcomm = '{
"merchantId": "11122333",
"amount": "100",
"currency": "050",
"description": "Reference_Number ",
"approveUrl": "http://192.168.220.43:8080/CityBankPHP_1.0.1/Approved.php",
"cancelUrl": "http://192.168.220.43:8080/CityBankPHP_1.0.1/Cancelled.php",
"declineUrl": "http://192.168.220.43:8080/CityBankPHP_1.0.1/Declined.php",
"userName": "test",
"passWord": "123456Aa",
"secureToken": "'.$transactionId.'"
}';


        $cblEcomm = ProcessRequest($postdataEcomm,$serviceUrlEcomm,$proxy,$proxyauth);
//print_r($cblEcomm);
// //echo $cblEcomm['responseCode'];
//exit;

        $URL = $cblEcomm['items']['url'];
        $orderId = $cblEcomm['items']['orderId'];
        $sessionId = $cblEcomm['items']['sessionId'];
        $redirectUrl = $URL."?ORDERID=".$orderId."&SESSIONID=".$sessionId;

        return $redirectUrl;


    }

    private function ProcessRequest($curl_post_data,$service_url,$proxy,$proxyauth)
    {
        $output = '';
        $certfile       = '/createorder.crt';
        $keyfile        = '/createorder.key';
        $cert_password = '';
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $service_url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt( $ch, CURLOPT_SSLCERT, getcwd() . $certfile );
        curl_setopt( $ch, CURLOPT_SSLKEY, getcwd() . $keyfile );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $output = curl_exec($ch);
        if (curl_error($ch)) {
            echo $error_msg = curl_error($ch);
        }
        $cblcz = json_decode($output, true );
        return $cblcz;
    }



}
