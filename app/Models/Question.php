<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // 这里也放开了属性保护
    protected $guarded = ['id'];

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
