<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Vérification de votre adresse e-mail')
            ->greeting('Bienvenue chez Auto Abda !')
            ->line('Veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse e-mail.')
            ->action('Vérifier l\'adresse e-mail', $verificationUrl)
            ->line('Si vous n\'avez pas créé de compte, aucune autre action n\'est nécessaire.')
            ->salutation('Cordialement, l\'équipe Auto Abda');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60), // validité du lien : 60 minutes
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
