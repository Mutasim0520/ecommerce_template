<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use App\Order;

class TickteSolved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public $subject;
    public $Ticket;
    public $body;

    public function __construct($Subject, $Ticket, $Body)
    {
        $this->subject =$Subject;
        $this->Ticket = $Ticket;
        $this->body = $Body;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.orderConfirmation')
                    ->subject($this->subject);
    }
}
