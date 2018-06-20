<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribersMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    public $body;
    public $subscriber;

    public function __construct($Subject, $Body, $Subscriber)
    {
        $this->subject =$Subject;
        $this->body = $Body;
        $this->subscriber = $Subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.SubcribersMail')
                    ->subject($this->subject);
    }
}
