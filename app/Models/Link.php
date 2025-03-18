<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Link extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'link'];

    public string $cacheKey = 'KAKU_bbs_links';

    protected int $cacheExpireInSeconds = 1440 * 60;

    public function getAllCached(): mixed
    {
        return Cache::remember($this->cacheKey, $this->cacheExpireInSeconds, function () {
            return Link::all();
        });
    }
}
