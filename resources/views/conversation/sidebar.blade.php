<div id="sidebar__display" class="conversation-list">
    @foreach($related as $conversation)
        @if($conversation->latestMessage)
            <div class="conversation-short">
                <div class="conversation-avatar">
                    <img src="{{$conversation->latestMessage->user->avatarUrl}}" />
                </div>
                <div class="inside">
                    <p class="creator">{{$conversation->latestMessage->user->name}}</p>
                    <p class="content">{{$conversation->latestMessage->body}}</p>
                </div>
            </div>
        @endif
    @endforeach
</div>