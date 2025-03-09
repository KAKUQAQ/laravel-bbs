<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['message'];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 关联子评论（楼中楼）
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class, 'parent_id')->with('user')->orderBy('created_at', 'asc');
    }

    /**
     * 关联父评论
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($reply) {
            Reply::where('parent_id', $reply->id)->delete();
        });
    }


    public function scopeRecent($query): mixed
    {
        return $query->orderBy('created_at', 'desc');
    }
}
