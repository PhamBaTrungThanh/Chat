<?php

namespace App\Listeners;

use App\Events\UserUploadAvatar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\Log;
class UploadToCloudinary implements ShouldQueue
{
    public $tries = 1;
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
        $debug = (env('APP_DEBUG')) ? "debug/" : "";
        Log::info('Full file path '.$event->file);
        $cloudder = Cloudder::upload($event->file, "{$debug}__user-{$event->user->id}__avatar");
        Log::info($cloudder);
        $result = Cloudder::getResult();
        $event->user->avatar()->update([
            "public_id" => $result["public_id"],
            "absolute_url" => $result["url"],
            "is_processing" => false,
        ]);
        return true;
    }
}
