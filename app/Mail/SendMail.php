<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;
    protected $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $subject)
    {
        $this->data = $data;
        $this->subject = $subject;

        // $this->pdf = base64_encode($pdf);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('CPA ERP system forget password')
            ->view('emails.forgot-password');

        // ->attachData(base64_decode($this->pdf), 'document.pdf', [
        // 'mime' => 'application/pdf',
        // ]);
    }
}
