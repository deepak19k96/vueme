<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserTopRatePsychics extends Mailable
{
    use Queueable, SerializesModels;

    private $psychics;

    private $user;

    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject, $psychics)
    {
        $this->subject = $subject;
        $this->psychics = $psychics;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.userTopRatePsychics")
        ->from('hello@psychics1on1.com', 'Psychics1on1 Team')
        ->subject( $this->user->userProfile->name.' | ' . $this->subject)
        ->with(['user' => $this->user, 'users' => $this->psychics]);
    }
}
