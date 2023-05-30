<?php

namespace App\Contracts\Mail;

interface MessageContract
{
    /**
     * @param $to
     * @param $content
     * @return int|null
     */
    public function send($to, $content);

    // public function queueMessages();

    public function sendMail($obj, $mail);

    // public function sendSms();
}
