<ul class="list-unstyled">
    @foreach($replies as $index=>$reply)
        <li class="d-flex" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
            <div class="media-left">
                <a href="{{ route('users.show', [$reply->user_id]) }}">
                    <img src="{{ $reply->user->avatar }}" class="media-object img-thumbnail mr-3" alt="{{ $reply->user->name }}" style="width: 48px; height: 48px;">
                </a>
            </div>
            <div class="flex-grow-1 ms-2">
                <div class="media-heading mt-0 mb-1 text-secondary">
                    <a class="text-decoration-none" href="{{ route('users.show', [$reply->user->id]) }}" title="{{ $reply->user->name }}">{{ $reply->user->name }}</a>
                </div>
                <span class="text-secondary">·</span>
                <span class="meta text-secondary" title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</span>
                <span class="meta float-end">
                    <a title="Delete">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </span>
            </div>
            <div class="reply-content text-secondary">
                {!! $reply->content !!}
            </div>
        </li>
        @if(!$loop->last)
            <hr>
        @endif
    @endforeach
</ul>
