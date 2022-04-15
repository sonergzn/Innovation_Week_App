<?php

namespace App\Models\Traits;

use App\Models\Like;
use App\Models\POst;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Likes
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}