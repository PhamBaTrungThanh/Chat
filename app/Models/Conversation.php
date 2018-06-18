<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Conversation extends Model
{
    use Notifiable;
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeSingle($query, array $array)
    {
        return $query->where("type", "single")
                     ->whereRaw("id = (SELECT conver1.conversation_id FROM conversation_user conver1, conversation_user conver2 WHERE conver1.user_id = ? AND conver2.user_id = ? AND conver1.conversation_id = conver2.conversation_id)", $array);
    }
    public function getOtherAttribute()
    {
        if ($this->type !== "single") {
            throw new Exception("Bad usecase, use others() instead");
        }
        $this->loadMissing("users");
        return $this->users->whereNotIn("id", [auth()->user()->id])->first();
    }

    public function getLatestNotificationAttribute()
    {
        $this->loadMissing("notifications");
        return optional($this->notifications)->first();
    }
    public function toOthers()
    {
        $this->loadMissing("users");
        return $this->users->whereNotIn("id", [auth()->user()->id])->all();
    }
}
