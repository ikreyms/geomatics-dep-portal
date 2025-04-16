<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyUserEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('mail.email-verification', [
            'verifyUrl' => $this->verificationUrl($notifiable),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    protected function verificationUrl($notifiable)
    {
        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'userhashid' => $notifiable->{config('hashid.field')},
                'emailHash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        $verifyUrl = str_replace(config('app.url') . '/api', config('app.client_url') . '/email/verify?verify_url=', $verifyUrl);
        return $verifyUrl;
    }

    public function viaQueues(): array
    {
        return [
            'mail' => 'mail-q',
        ];
    }
}
