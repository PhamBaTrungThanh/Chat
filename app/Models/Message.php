<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
class Message extends Model
{
    protected $fillable = ["body", "conversation_id", "user_id"];
    protected $touches = ['conversation'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getBodyAttribute($body)
    {
        return new HtmlString($body);
    }
    
}
