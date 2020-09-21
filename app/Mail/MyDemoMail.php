<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyDemoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $users;
    private $attachment;

    public function __construct($users, $attachment = null)
    {
    	$this->users = $users;
    	$this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {

    	if ($this->attachment) {
    		return $this->markdown('emails.myDemoMail',[
	        	'users' => $this->users
	        ])->attach($this->attachment);
    	}

		return $this->markdown('emails.myDemoMail',[
        	'users' => $this->users
        ]);
    }
}
