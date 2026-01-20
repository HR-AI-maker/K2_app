<?php

namespace App\Mail;

use App\Models\OtpVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpVerification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public OtpVerification $otpVerification,
        public string $email
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Alpine Account - OTP Code',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp-verification',
            with: [
                'otp' => $this->otpVerification->otp_code,
                'email' => $this->email,
                'expiresAt' => $this->otpVerification->expires_at->format('H:i A'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
