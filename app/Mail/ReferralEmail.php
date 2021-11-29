<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferralEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $email;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$email)
    {
        $this->user = $user;
        $this->email = $email;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.referralEmail")
        ->from('hello@psychics1on1.com', 'Psychics1on1 Team')
        ->subject( "Your Friend ".$this->user->userProfile->name." sent you $10!")
        ->with(['user' => $this->user,'email' => $this->email]);
    }
}
