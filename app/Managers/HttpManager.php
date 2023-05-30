<?php
namespace App\Managers;

use App\Contracts\HttpContact;
use GuzzleHttp\Client as GuzzleClient;


/**
 * Class  as a services to maintain some business logic with db operation
 *
 * @package App\Managers\HttpManager
 */
class HttpManager implements HttpContact
{
    public function http_get($url, $header, $body)
    {
        // TODO: Implement http_get() method.
        if(!$header){
            $header = [];
        }

        $client = new GuzzleClient([
            'headers' => $header
        ]);
        $oResponse = $client->request('GET', $url);

        $oResponseBody = json_decode( $oResponse->getBody());

        return $oResponseBody;

    }

    function http_post($url, $header, $body)
    {
        // TODO: Implement http_post() method.
        if(!$header){
            $header = [];
        }

        if(!$body){
            $body = [];
        }

        $client = new GuzzleClient([
            'headers' => $header
        ]);
        $oResponse = $client->request('POST', $url, ['body' => json_encode( $body,
            JSON_UNESCAPED_SLASHES)]);

        $oResponseBody = json_decode( $oResponse->getBody());

        return $oResponseBody;
    }
}
