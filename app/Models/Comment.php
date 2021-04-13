<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    use Traits\VoteTrait;
    use Traits\InvitedUsersTrait;

    protected $guarded = ['id'];
    protected $with = ['owner'];
    protected $appends = [
        'upVotesCount',
        'downVotesCount',
    ];

    public function commented()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
