<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
	public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
		// $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		return $this->from('narindersingh22111991@gmail.com')->subject("User Activation")->view('mail.sendemail');
        // return $this->view('view.name');
    }
}