<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestReview extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.   
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.clientPleaseReview")
        ->from('support@psychics1on1.com', 'Psychics1on1 Team')
        ->subject($this->appointment->psychic()->first()->UserProfile()->first()->display_name.
        ' | '.$this->appointment->user()->first()->UserProfile()->first()->name.' Did You Enjoy Your Reading?')
        ->with(['appointment'=>$this->appointment]);
    }
}
