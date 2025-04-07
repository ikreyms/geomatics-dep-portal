<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private User $user,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Verification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.email-verification-mail',
            with: [
                'verifyUrl' => $this->generateVerifyUrl(),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    private function generateVerifyUrl()
    {
        $frontEndUrl = config('app.client_url') . '/email/verify';
        // http:://localhost:3000/email/verify

        $baseUrl = config('app.url');
        // http://localhost:8000

        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'userhashid' => $this->user->hashid,
                'emailHash' => sha1($this->user->getEmailForVerification()),
            ]
        );
        // http://localhost:8000/api/verify-email/{user}/{emailHash}

        // Extract only the path from the verify URL
        $path = parse_url($verifyUrl, PHP_URL_PATH);
        // This will give us something like /api/verify-email/{user}/{emailHash}

        // Remove the /api part of the path
        $path = Str::replaceFirst('/api', '', $path);

        return $frontEndUrl . '?verify_url=' . urlencode($path);
        // http:://localhost:3000/email/verify?verify_url=verify-email/{user}/{emailHash}
    }
}
