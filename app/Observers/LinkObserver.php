<?php

namespace App\Observers;

use App\Models\Link;
use Illuminate\Support\Facades\Cache;

class LinkObserver
{
    public function saved(Link $link): void
    {
        Cache::forget($link->cacheKey);
    }
}
