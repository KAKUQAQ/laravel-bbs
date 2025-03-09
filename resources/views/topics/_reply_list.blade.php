<ul class="list-unstyled">
    @foreach($replies as $index => $reply)
        @if(!$reply->parent_id) <!-- 仅显示主评论 -->
        <li class="d-flex align-items-start py-3 border-bottom" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
            <div class="me-3">
                <a href="{{ route('users.show', [$reply->user_id]) }}">
                    <img src="{{ $reply->user->avatar }}" class="rounded-circle" alt="{{ $reply->user->name }}" style="width: 48px; height: 48px;">
                </a>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                    <div>
                        <a class="fw-bold text-decoration-none" href="{{ route('users.show', [$reply->user->id]) }}">{{ $reply->user->name }}</a>
                        <span class="text-muted small">· {{ $reply->created_at->diffForHumans() }}</span>
                    </div>
                    @can('destroy', $reply)
                        <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this reply?')">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link text-secondary p-0"><i class="far fa-trash-alt"></i></button>
                        </form>
                    @endcan
                </div>
                <div class="text-secondary mt-1">
                    {!! $reply->message !!}
                </div>

                <!-- 下拉按钮和回复按钮 -->
                <div class="mt-2 d-flex align-items-center">
                    <button class="btn btn-sm btn-outline-secondary me-2" type="button" data-bs-toggle="collapse" data-bs-target="#replies-{{ $reply->id }}" aria-expanded="false">
                        <i class="fas fa-angle-down"></i> More replies...
                    </button>
                    <button class="btn btn-sm btn-outline-primary" type="button" onclick="showReplyForm({{ $reply->id }})">
                        <i class="fas fa-reply"></i> Reply
                    </button>
                </div>

                <!-- 回复输入框 -->
                <div id="reply-form-{{ $reply->id }}" class="mt-2 collapse">
                    <form action="{{ route('replies.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                        <textarea class="form-control" name="message" rows="2" placeholder="Something you wanna say..."></textarea>
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Reply</button>
                    </form>
                </div>

                <!-- 楼中楼（子评论） -->
                @if ($reply->replies->count())
                    <div class="collapse mt-2" id="replies-{{ $reply->id }}">
                        <ul class="list-unstyled ps-4 border-start">
                            @foreach ($reply->replies as $childReply)
                                <li class="d-flex align-items-start py-2">
                                    <div class="me-2">
                                        <a href="{{ route('users.show', [$childReply->user_id]) }}">
                                            <img src="{{ $childReply->user->avatar }}" class="rounded-circle" alt="{{ $childReply->user->name }}" style="width: 36px; height: 36px;">
                                        </a>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <a class="fw-bold text-decoration-none" href="{{ route('users.show', [$childReply->user->id]) }}">{{ $childReply->user->name }}</a>
                                                <span class="text-muted small">· {{ $childReply->created_at->diffForHumans() }}</span>
                                            </div>
                                            @can('destroy', $childReply)
                                                <form action="{{ route('replies.destroy', $childReply->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this reply?')">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-link text-secondary p-0"><i class="far fa-trash-alt"></i></button>
                                                </form>
                                            @endcan
                                        </div>
                                        <div class="text-secondary mt-1">
                                            {!! $childReply->message !!}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </li>
        @endif <!-- 仅显示主评论 结束 -->
    @endforeach
</ul>

<script>
    function showReplyForm(replyId) {
        document.getElementById('reply-form-' + replyId).classList.toggle('show');
    }
</script>
