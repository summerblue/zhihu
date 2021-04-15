<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
		'email_verified_at' => 'datetime',
	];

    protected $appends = [ 'userAvatar'];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

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
}
