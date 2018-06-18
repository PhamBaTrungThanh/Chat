<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessagePosted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $message;
    private $creator;
    public function __construct($message, $creator)
    {
        $this->message = $message;
        $this->creator = $creator;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }
    public function toDatabase()
    {
        return [
            "creator" => [
                "id" => $this->creator->id,
                "avatar" => $this->creator->avatar,
            ],
            "message" => [
                "body" => $this->message->body,
            ],
        ];
    }
    public function toBroadcast()
    {
        return [
            "creator" => [
                "id" => $this->creator->id,
                "avatar" => $this->creator->avatar,
            ],
            "message" => [
                "body" => $this->message->body,
            ],
        ];
    }

}
