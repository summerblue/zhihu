<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    use Traits\VoteTrait;

    protected $guarded = ['id'];
    protected $appends = [
        'upVotesCount',
        'downVotesCount',
    ];
}
