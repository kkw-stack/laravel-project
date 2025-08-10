<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangePasswordMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public string $token,
        public string $email,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Password Reset Email'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.change-password',
            with: [
                'url' => url('en/auth/change-password', ['token' => $this->token, 'email' => $this->email]),
            ],
        );
    }
}
