<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MenstrualCycleUpdated extends Notification
{
    use Queueable;
    public $cycle;
    /**
     * Create a new notification instance.
     */
    public function __construct($cycle)
    {
        $this->cycle = $cycle;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database']; // Or 'mail', 'broadcast', etc.
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your menstrual cycle progress has been updated.',
            'progress' => $this->cycle->progress,
            'is_completed' => $this->cycle->is_completed,
            'cycle_id' => $this->cycle->id,
        ];
    }


}
