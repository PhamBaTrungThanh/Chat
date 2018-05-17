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

    public $friendshipsList, $awaitingCount;
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
    public function getAllFriendshipsList()
    {
        if (blank($this->friendshipsList)) {
            $this->friendshipsList = $this->getAllFriendships();
        } 
        return $this->friendshipsList;
    }
    public function getAwaitingCountAttribute()
    {
        if (blank($this->awaitingCount)) {
            $list = $this->getAllFriendshipsList();
            $count = 0;
            foreach ($list as $friendship) {
                if ($friendship->status === 0) {
                    if ($this->id = $friendship->recipient_id) {
                        $count++;
                    }
                }
            }
            $this->awaitingCount = $count;
        }
        return $this->awaitingCount;
    }
    public function getRelationshipsIdsAttribute()
    {
        $list = $this->getAllFriendshipsList();
        $userIds = [];
        list($pendingFriends, $friends, $rejectFriends, $blockedFriends, $awaiting) = array([],[],[],[],[]);

        foreach ($list as $friendship) {
            $friendId = ($this->id === $friendship->sender_id) ? $friendship->recipient_id : $friendship->sender_id;
            $userIds[] = $friendId;
            switch ($friendship->status) {
                case 0:
                    # PENDING
                    if ($this->id === $friendship->sender_id) {
                        $pendingFriends[] = $friendship->recipient_id;
                    } else {
                        # AWAITING
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
        $this->awaitingCount = count($awaiting);
        return [
            $awaiting,
            $friends,
            $rejectFriends,
            $blockedFriends,
            $pendingFriends,
            $userIds,
            $list,
        ];
    }
    public function getAllRelationshipModelsAttribute()
    {
        list($awaitingModels, $friendsModels, $rejectedModels, $blockedModels, $pendingModels) = array([],[],[],[],[]);
        list($awaiting, $friends, $rejected, $blocked, $pending, $ids) = $this->relationshipsIds;
        $friendCollection = self::whereIn('id', $ids)->get();
        foreach ($friendCollection as $aFriend) {
            if (in_array($aFriend->id, $awaiting)) {
                $aFriend->status = "AWAITING";
                $awaitingModels[] = $aFriend;
                continue;
            } else if (in_array($aFriend->id, $friends)) {
                $aFriend->status = "FRIEND";
                $friendsModels[] = $aFriend;
                continue;
            } else if (in_array($aFriend->id, $rejected)) {
                $aFriend->status = "REJECTED";
                $rejectedModels[] = $aFriend;
                continue;
            } else if (in_array($aFriend->id, $blocked)) {
                $aFriend->status = "BLOCKED";
                $blockedModels[] = $aFriend;
                continue;
            } else if (in_array($aFriend->id, $pending)) {
                $aFriend->status = "PENDING";
                $pendingModels[] = $aFriend;
                continue;
            }
        }
        return [
            collect($awaitingModels),
            collect($friendsModels),
            collect($rejectedModels),
            collect($blockedModels),
            collect($pendingModels),
            $friendCollection,
        ];        
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
