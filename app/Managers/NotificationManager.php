<?php
namespace App\Managers;

use App\Contracts\HttpContact;
use App\Contracts\LogContact;
use App\Contracts\NotificationContact;
use App\Enums\YesNoFlag;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Auth;


/**
 * Class  as a services to maintain some business logic with db operation
 *
 * @package App\Managers\HttpManager
 */
class NotificationManager implements NotificationContact
{

    private $http_contact;
    private $log_contact;


    public function __construct(HttpContact $http_contact,LogContact $log_contact)
    {
        $this->http_contact = $http_contact;
        $this->log_contact = $log_contact;
    }


    public function send_sms($user_id,$mobile, $message)
    {
        $encoded_string = e($message);
        $url = 'https://api.mobireach.com.bd/SendTextMessage?Username=cns&Password=Ikram*2017&From=8801847169958&To='.$mobile.'&Message=' . $encoded_string;

        $response = $this->http_contact->http_get($url,null,null);
        $this->log_contact->save_sms_log($user_id,null,$mobile,"SMS",$encoded_string,$response);

        // TODO: Implement send_sms() method.
    }

    public function send_email($transaction_id, $src_name, $completed_yn, $raw_data)
    {
        // TODO: Implement send_email() method.
    }
}
