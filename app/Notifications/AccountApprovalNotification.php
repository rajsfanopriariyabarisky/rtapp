<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AccountApprovalNotification extends Notification
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status; // ini string, bukan array
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Status Akun Anda')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Status akun Anda telah diperbarui menjadi: ' . $this->status)
            ->action('Login Sekarang', url('/login'))
            ->line('Terima kasih telah mendaftar di sistem kami.');
    }
}

