<?php

namespace App\Observers;

use App\Models\Reply;
use App\Models\User;
use App\Notifications\TopicReplied;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->topic->updateReplyCount();
        if ($reply->user_id !== $reply->topic->user_id) {
            $reply->topic->user->notify(new TopicReplied($reply));
        }
    }

    public function creating(Reply $reply)
    {
        $reply->message = clean($reply->message, 'user_topic_body');
        $validator = Validator::make($reply->toArray(), [
            'message' => 'required|min:2',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function delete(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
