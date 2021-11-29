<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreditsOffer extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
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
        return $this->markdown("emails.creditsOffer")
        ->from('support@psychics1on1.com', 'Psychics1on1 Team')
        ->subject($this->user->userProfile()->first()->name.' | Try Psychics1on1 with $10 Off')
        ->with(['user' => $this->user]);
    }
}
