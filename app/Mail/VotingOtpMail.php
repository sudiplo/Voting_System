<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VotingOtpMail extends Mailable
{
    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Voting OTP Verification')
                    ->view('emails.voting-otp'); // ✅ MUST MATCH FILE PATH
    }
}
