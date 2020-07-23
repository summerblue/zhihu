<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;
    use \App\Models\Traits\ActiveUserHelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [ 'userAvatar'];

    public function getUserAvatarAttribute()
    {
        return $this->avatar();
    }

    public function avatar()
    {
        if ($this->avatar_path) {
            $file_path = $this->avatar_path;
        } else {
            $file_path = 'avatars/default.png';
        }

        return asset('storage/' . $file_path);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
