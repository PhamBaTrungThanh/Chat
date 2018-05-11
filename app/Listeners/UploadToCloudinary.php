<?php

namespace App\Listeners;

use App\Events\UserUploadAvatar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use JD\Cloudder\Facades\Cloudder;

class UploadToCloudinary
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserUploadAvatar  $event
     * @return void
     */
    public function handle(UserUploadAvatar $event)
    {
        $cloudder = Cloudder::upload($event->file, "user-{$event->user->id}__avatar");
        $result = Cloudder::getResult();
        $event->user->update(['avatar' => $result['secure_url']]);
    }
}
