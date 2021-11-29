<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SpanishPsychics extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.   
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.spanishPsychics")
        ->from('support@psychics1on1.com', 'Psychics1on1 Team')
        ->subject('Spanish Speaking Psychics Needed ')
        ->with(['user'=>$this->user]);
    }
}
