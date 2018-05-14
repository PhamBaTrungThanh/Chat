<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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
            return $this->avatar;
        } else {
            return str_replace_first("image/upload/", "image/upload/" . config('images.avatar_transformation') . "/", $this->avatar);
        }
    }
}
