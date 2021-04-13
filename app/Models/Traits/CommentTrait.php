<?php

namespace App\Models\Traits;

trait CommentTrait
{
    public function comment($content, $user)
    {
        $comment =  $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content
        ]);

        return $comment;
    }

    public function comments()
    {
        return $this->morphMany(\App\Models\Comment::class, 'commented');
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments->count();
    }
}
