<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Day10ClientEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $users;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $users)
    {
        $this->user = $user;
        $this->users = $users;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.10DayAbilitiesTriggeredEmail")
        ->from('hello@psychics1on1.com', 'Psychics1on1 Team')
        ->subject( $this->user->userProfile->name.' | Trusting Intuition is the Beginning of Wisdom')
        ->with(['user' => $this->user, 'users' => $this->users]);
    }
}
