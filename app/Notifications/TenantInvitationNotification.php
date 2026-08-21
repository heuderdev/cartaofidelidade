<?php

namespace App\Notifications;

use App\Models\TenantInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class TenantInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly TenantInvitation $invitation,
        private readonly string $token,
    ) {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $acceptUrl = URL::temporarySignedRoute(
            'tenant-invitation.accept',
            $this->invitation->expires_at,
            [
                'invitation' => $this->invitation->getKey(),
                'token' => $this->token,
            ]
        );

        return (new MailMessage)
            ->subject(
                "Convite para {$this->invitation->tenant->name}"
            )
            ->greeting('Olá!')
            ->line(
                "Você foi convidado para entrar no tenant {$this->invitation->tenant->name}."
            )
            ->line(
                "Sua função será: {$this->invitation->role}."
            )
            ->action(
                'Aceitar convite',
                $acceptUrl
            )
            ->line(
                'Este convite expira em '
                . $this->invitation->expires_at
                    ->timezone('America/Sao_Paulo')
                    ->format('d/m/Y H:i')
                . '.'
            )
            ->line(
                'Se você não esperava este convite, ignore este e-mail.'
            );
    }
}
