<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
class FriendRequested extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $friend;
    public function __construct($friend)
    {
        $this->friend = $friend;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            "friend" => [
                "id" => $this->friend->id
            ],
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            "friend" => [
                "id" => $this->friend->id,
                "name" => $this->friend->name,
                "url" => route("user.show", $this->friend),
            ],
            "message" => __("friend.request.received", ["username" => $this->friend->name]),
        ]);
    }
}
