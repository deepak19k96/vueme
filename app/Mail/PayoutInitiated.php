<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayoutInitiated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $payout;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $payout)
    {
        $this->user = $user;
        $this->payout = $payout;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("emails.payoutInitiated")
        ->from('support@psychics1on1.com', 'Psychics1on1 Team')
        ->subject( $this->user->UserProfile()->first()->display_name.' | Your Payout Is On The Way! ')
        ->with(['user' => $this->user, 'payout' => $this->payout]);
    }
}
