<?php
namespace App\Notifications;

use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TopicReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * @param mixed $notifiable
     * @return string[]
     */
    public function via(mixed $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(mixed $notifiable): array
    {
        $topic = $this->reply->topic;
        $link = $topic->slug . '#reply' . $this->reply->id;
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->message,
            'user_id' => $this->reply->user_id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'topic_link' => $link,
            'topic_id' => $topic->id,
            'topic_title' => $topic->title,
        ];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $url = $this->reply->topic->slug . '#reply' . $this->reply->id;
        return (new MailMessage)
            ->line('Someone has replied to your post.')
            ->action('Click to view the reply', $url);
    }

    public function toArray(mixed $notifiable): array
    {
        return [];
    }
}
