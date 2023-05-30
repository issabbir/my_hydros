<?php
/**
 * Created by PhpStorm.
 * User: MOU
 * Date: 30-Jun-20
 * Time: 10:07 PM
 */
namespace App\Helpers;

class CommonResponse{

    public $messageCode;
    public $message;


    function __construct($mCode,$msg)
    {
        $this->messageCode = $mCode;
        $this->message = $msg;
    }
}