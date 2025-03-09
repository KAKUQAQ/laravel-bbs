<?php

namespace App\Observers;

use App\Models\Topic;
use Illuminate\Support\Facades\DB;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function created(Topic $topic)
    {
        $topic->slug = env('APP_URL') . '/topics/' . $topic->id;
        $topic->save();
    }

    public function delete(Topic $topic)
    {
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }

}
