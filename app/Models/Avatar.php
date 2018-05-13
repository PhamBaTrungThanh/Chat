<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = ["public_id", "absolute_url"];
    protected $attributes = [
        "absolute_url" => "images/default-avatar.png",
        "public_id" => "default",
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    public function getUrlAttribute()
    {
        if ($this->public_id === "default") {
            return $this->absolute_url;
        } else {
            return "//res.cloudinary.com/{config('cloudder.cloudName')}/image/upload/{config('images.avatar_transformation')}/{$this->public_id}.{config('images.avatar_extension')}";
        }
    }
}
