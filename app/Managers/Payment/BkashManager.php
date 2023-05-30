<?php
namespace App\Managers\Payment;

use App\Contracts\HttpContact;
use App\Contracts\Payment\BkashContact;
use App\Enums\BkashConstant;
/**
 * Class  as a services to maintain some business logic with db operation
 *
 * @package App\Managers\Authorization
 */
class BkashManager implements BkashContact
{
    private $http_manager;

    public function __construct(HttpContact $http_contact)
    {
        $this->http_manager = $http_contact;
    }

    public function create_token(){

        $username = config('bkash.username');
        $password = config('bkash.password');
        $tokenUrl = config('bkash.tokenUrl');

        $app_key = config('bkash.app_key');
        $app_secret = config('bkash.app_secret');

        $headers = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'username' => $username,
            'password' => $password,
        ];
        $body = ['app_key' => $app_key, 'app_secret' => $app_secret];

        $oResponse = $this->http_manager->http_post($tokenUrl,$headers,$body);

        return $oResponse;

    }


    public function create_payment($id_token,$payerReference,$amount,$merchantInvoiceNumber){

        $app_key = config('bkash.app_key');

        $headers = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'authorization' => $id_token,
            'x-app-key' => $app_key,
        ];

        $body = [
            'mode' => BkashConstant::MODE,
            'payerReference' => $payerReference,
            'amount' => $amount,
            'currency' => BkashConstant::CURRENCY,
            'intent' => BkashConstant::INTENT,
            'merchantInvoiceNumber' => $merchantInvoiceNumber
        ];

        $createPaymentUrl = config('bkash.createPaymentUrl');

        $create_response = $this->http_manager->http_post($createPaymentUrl,$headers,$body);
        return $create_response;

    }

    public  function execute_payment($id_token, $paymentID)
    {
        // TODO: Implement execute_payment() method.
        $app_key = config('bkash.app_key');

        $headers = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'authorization' => $id_token,
            'x-app-key' => $app_key,
        ];

        $body = [
            'paymentID' => $paymentID,
        ];

        $executePaymentUrl = config('bkash.executePaymentUrl');

        $url = $executePaymentUrl.'/'.$paymentID;

        $execute_response = $this->http_manager->http_post($url,$headers,$body);

        return $execute_response;

    }

    function query_payment($id_token, $paymentID)
    {
        // TODO: Implement query_payment() method.

        $app_key = config('bkash.app_key');

        $queryPaymentUrl = config('bkash.queryPaymentUrl');


        $headers = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'authorization' => $id_token,
            'x-app-key' => $app_key,
        ];

        /*$body = [
            'paymentID' => $paymentID,
        ];*/

        $url = $queryPaymentUrl . '/' . $paymentID;

        $query_response = $this->http_manager->http_get($url, $headers, null);

        return $query_response;

    }
}
