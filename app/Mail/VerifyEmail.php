<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        // ✅ Generate the verification URL using the named route
        $verificationUrl = route('verify.email', ['token' => $this->user->email_verification_token]);

        return $this->from('no_reply@menalqalb.com', config('app.name')) // <- Set the sender
            ->subject(__('Verify Your Email'))
            ->view('emails.verify-email')
            ->with([
                'user' => $this->user,
                'verificationUrl' => $verificationUrl,
            ]);
    }
}
