<?php

namespace App\Models\Traits;

use App\Models\Activity;

trait RecordActivityTrait
{
    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
