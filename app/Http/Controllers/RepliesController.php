<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(ReplyRequest $request, Reply $reply): RedirectResponse
	{
		$reply->message = $request->message;
        $reply->user_id = Auth::id();
        // 自动获取 `topic_id`
        if ($request->has('parent_id')) {
            $parentReply = Reply::findOrFail($request->parent_id);
            $reply->topic_id = $parentReply->topic_id; // 子评论继承话题ID
            $reply->parent_id = $parentReply->id;
        } else {
            $reply->topic_id = $request->topic_id; // 直接评论话题
        }
        $reply->save();
        return redirect()->to($reply->topic->slug . '#reply' . $reply->id)->with('success', 'Reply added!');
	}

    public function index($topicId)
    {
        $replies = Reply::where('topic_id', $topicId)
            ->whereNull('parent_id') // 仅获取顶层评论
            ->with('user', 'replies.replies.user') // 预加载子评论
            ->orderBy('created_at', 'desc')
            ->get();

        return view('topics.show', compact('replies'));
    }

	public function destroy(Reply $reply): RedirectResponse
	{
		$this->authorize('destroy', $reply);

		$this->deleteReplyWithChildren($reply);

		return redirect()->to($reply->topic->slug)->with('success', 'Deleted successfully.');
	}

    private function deleteReplyWithChildren(Reply $reply)
    {
        $children = Reply::where('parent_id', $reply->id)->get();
        foreach ($children as $child) {
            $this->deleteReplyWithChildren($child);
        }
        $reply->delete();
    }
}
