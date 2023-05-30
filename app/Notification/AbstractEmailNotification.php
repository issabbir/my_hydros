<?php
/**
 * Created by PhpStorm.
 * User: MOU
 * Date: 16-Jul-20
 * Time: 12:34 PM
 */


namespace App\Notification;

abstract class AbstractEmailNotification {

    public abstract function send_email($to_address , $body);
}