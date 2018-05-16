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
    public function cancelFriendRequest(self $recipient)
    {
        return $this->findFriendship($recipient)->delete();
    }
    public function getRelationshipsIdsAttribute()
    {
        $list = $this->getAllFriendships();
        $userIds = [];
        list($pendingFriends, $friends, $rejectFriends, $blockedFriends, $awaiting) = array([],[],[],[],[]);

        foreach ($list as $friendship) {
            $friendId = ($this->id === $friendship->sender_id) ? $friendship->recipient_id : $friendship->sender_id;
            switch ($friendship->status) {
                case 0:
                    # PENDING
                    if ($this->id === $friendship->sender_id) {
                        $pendingFriends[] = $friendship->recipient_id;
                    } else {
                        $awaiting[] = $friendship->sender_id;
                    }
                    break;
                case 1:
                    # ACCEPTED 
                    $friends[] = $friendId;
                    break;
                case 2:
                    # DENIED
                    $rejectFriends[] = $friendId;
                    break;
                case 3:
                    # BLOCKED
                    $blockedFriends[] = $friendId;
                    break;

                default:
                    #AWAITING

                    break;
            }
        }
        return [
            $awaiting,
            $friends,
            $rejectFriends,
            $blockedFriends,
            $pendingFriends,
            $list,
        ];
    }
    public function getRelationshipsAttribute()
    {

        $queries = [];
        list($pendingFriends, $friends, $rejectFriends, $blockedFriends) = array([],[],[],[]);
        foreach ($list as $friendship) {
            $queries[] = ($userId === $friendship->sender_id) ? $friendship->recipient_id : $friendship->sender_id;
        }
        $users = User::whereIn('id', $queries)->get()->keyBy('id');
        foreach ($list as $friendship) {
            $actor = ($userId === $friendship->sender_id) ? $friendship->recipient_id : $friendship->sender_id;
            $friend = $users[$actor];
            switch ($friendship->status) {
                case 0:
                    # PENDING
                    $friend->status = "PENDING";
                    $pendingFriends[] = $friend;
                    break;
                case 1:
                    # ACCEPTED 
                    $friend->status = "ACCEPTED";
                    $friends[] = $friend;
                    break;
                case 2:
                    # DENIED
                    $friend->status = "DENIED";
                    $rejectFriends[] = $friend;
                    break;
                case 3:
                    # BLOCKED
                    $friend->status = "BLOCKED";
                    $blockedFriends[] = $friend;
                    break;
                default:
                    # AWAITING

                    break;
            }
        }
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
