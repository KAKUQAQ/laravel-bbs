<?php

namespace App\Models\Traits;

use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use PhpParser\ErrorHandler\Collecting;

trait ActiveUserHelper
{
    protected array $users = [];

    protected int $topic_weight = 4;
    protected int $reply_weight = 1;
    protected int $pass_days = 7;
    protected int $user_number = 5;

    protected string $cache_key = 'KAKUBBS202501-active-users';
    protected int $cache_expire_in_seconds = 65*60;

    public function getActiveUsers(): Collection|array
    {
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function () {
            return $this->calculateActiveUsers();
        });
    }
    public function calculateAndCacheActiveUsers(): void
    {
        $active_users = $this->calculateActiveUsers();
        $this->cacheActiveUsers($active_users);
    }

    public function calculateActiveUsers(): Collection|array
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        $users = Arr::sort($this->users, function ($user) {
            return $user['score'];
        });

        $users = array_reverse($users, true);

        $users = array_slice($users, 0, $this->user_number, true);

        $active_users = collect();

        foreach ($users as $user_id => $user) {
            $user = $this->find($user_id);
            if ($user) {
                $active_users->push($user);
            }
        }
        return $active_users;
    }

    protected function cacheActiveUsers($active_users): void
    {
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_seconds);
    }

    protected function calculateTopicScore(): void
    {
        $topic_users = Topic::query()->select(DB::raw('user_id, count(*) as topic_count'))
            ->where('created_at', '>=', now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        foreach ($topic_users as $user) {
            $this->users[$user->user_id]['score'] = $user->topic_count * $this->topic_weight;
        }
    }

    protected function calculateReplyScore(): void
    {
        $reply_users = Reply::query()->select(DB::raw('user_id, count(*) as topic_count'))
            ->where('created_at', '>=', now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        foreach ($reply_users as $user) {
            $reply_score = $user->relpy_count * $this->reply_weight;
            if (isset($this->users[$user->user_id])) {
                $this->users[$user->user_id]['score'] += $reply_score;
            } else {
                $this->users[$user->user_id]['score'] = $reply_score;
            }
        }
    }
}
