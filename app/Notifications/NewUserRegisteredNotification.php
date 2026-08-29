<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class NewUserRegisteredNotification extends Notification
{
    public User $newUser;

    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pendaftaran Akun Baru Menunggu Persetujuan')
            ->greeting('Halo ' . $notifiable->name)
            ->line('Ada pengguna baru yang mendaftar:')
            ->line('Nama: ' . $this->newUser->name)
            ->line('Email: ' . $this->newUser->email)
            ->line('Role: ' . $this->newUser->role)
            ->action('Tinjau Akun', url('/akun-pending'))
            ->line('Silakan setujui atau tolak akun ini melalui dashboard.');
    }
}

