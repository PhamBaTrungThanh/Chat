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
    private $conversation;
    public function __construct($conversation, $message, $creator)
    {
        $this->message = $message;
        $this->creator = $creator;
        $this->conversation = $conversation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toBroadcast()
    {
        return [
            "conversation_id" => $this->conversation->id,
            "conversation_name" => $this->conversation->name,
            "creator" => [
                "id" => $this->creator->id,
                "name" => $this->creator->name,
                "avatar" => $this->creator->avatarUrl,
            ],
            "message" => [
                "body" => $this->message,
            ],
        ];
    }

}
