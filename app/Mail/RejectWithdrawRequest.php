<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectWithdrawRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $reason;

    public function __construct($user,$message="")
    {
        $this->user = $user;
        $this->reason = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.General.withdraw_reject', [
            'user' => $this->user,
            'reason' => $this->reason
        ])->subject('Withdraw request rejected');
        
    }
}
