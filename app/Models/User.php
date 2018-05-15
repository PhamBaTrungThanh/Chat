<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $attributes = [
        "avatar" => "images/default-avatar.png",
    ];
    // protected $with = ["conversations"];
    // protected $withCount = ["conversations"];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function username() 
    {
        return 'email';
    }
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar === "images/default-avatar.png") {
            return asset($this->avatar);
        } else {
            return str_replace_first("image/upload/", "image/upload/" . config('images.avatar_transformation') . "/", $this->avatar);
        }
    }
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }
    public function getFriendsAttribute()
    {
        return $this->getFriends();
    }
    public function generateFriendsRelationships()
    {
        $friendships = $this->getPendingFriendships();
        $pending = [];
        $awaiting = [];
        foreach ($friendships as $friendship) {
            if ($friendship->sender_id === $this->id) {
                $pending[] = $friendship->recipient_id;
                continue;
            }
            if ($friendship->recipient_id === $this->id) {
                $awaiting[] = $friendship->sender_id;
                continue;
            }
        }

        return [
            $pending,
            $awaiting,
        ];
    }

}
