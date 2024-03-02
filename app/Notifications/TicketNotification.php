<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public String $message;

    private $ticket_id;

    public function __construct($message, $ticket_id)
    {
        $this->message =  $message;
        $this->ticket_id = $ticket_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
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
     * @return BroadcastMessage
     */
    public function toBroadcast(object $notifiable)
    {
        return  new BroadcastMessage([
            'message' => "$this->message"
        ]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray(object $notifiable)
    {
        return [
            'message' => $this->message,
            'id' =>  $this->ticket_id,
        ];
    }
}
