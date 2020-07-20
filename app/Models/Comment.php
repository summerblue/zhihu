<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use \App\Models\Traits\VoteTrait;

    protected $guarded = ['id'];

    protected $appends = [
        'upVotesCount',
        'downVotesCount',
        'commentsCount',
    ];
}
