<li class="d-flex @if(!$loop->last) border-bottom @endif">
    <div>
        <a href="{{ route('users.show', $notification->data['user_id']) }}">
            <img src="{{ $notification->data['user_avatar'] }}" class="img-thumbnail me-3" alt="{{ $notification->data['user_name'] }}" style="width: 48px; height: 48px;">
        </a>
    </div>
    <div class="flex-grow-1 ms-2">
        <div class="mt-0 mb-1 text-secondary">
            <a class="text-decoration-none" href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
            Posted a comment on
            <a class="text-decoration-none" href="{{ $notification->data['topic_link'] }}">{{ $notification->data['topic_title'] }}</a>
            <span class="meta float-end" title="{{ $notification->created_at }}">
                <i class="far fa-clock"></i>
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>
        <div class="reply-content">
            {!! $notification->data['reply_content'] !!}
        </div>
    </div>
</li>
