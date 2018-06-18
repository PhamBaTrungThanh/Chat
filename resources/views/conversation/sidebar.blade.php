<div id="sidebar__display" class="conversation-list" data-update-url="{{route('conversation.sidebar', $conversation)}}">
    @if (count($conversation->messages) > 0)
        <a class="conversation-short is-active link-disabled" id="conversation_sidebar__{{$conversation->id}}">
            <div class="conversation-avatar">
                <img src="{{$conversation->latestMessage->user->avatarUrl}}" />
            </div>
            <div class="inside"> 
                <p class="conversation-title">{{$conversation->name}}</p>
                <p class="content">{{($conversation->latestMessage->user->id !== auth()->user()->id) ? $conversation->latestMessage->user->name : "Bạn"}}: {{$conversation->latestMessage->body}}</p>
            </div>
        </a>        
    @endif
    @foreach($related as $c)
        @if($c->latestMessage && $c->id !== $conversation->id)
            <a class="conversation-short {{($c->id === $conversation->id) ? 'is-active link-disabled' : ''}}" 
                id="conversation_sidebar__{{$c->id}}"
                @if($c->id !== $conversation->id)href="{{route('conversation.show', $c)}}"@endif>
                <div class="conversation-avatar">
                    <img src="{{$c->latestMessage->user->avatarUrl}}" />
                </div>
                <div class="inside"> 
                    <p class="conversation-title">{{$c->name}}</p>
                    <p class="content">{{($c->latestMessage->user->id !== auth()->user()->id) ? $c->latestMessage->user->name : "Bạn"}}: {{$c->latestMessage->body}}</p>
                </div>
            </a>
        @endif
    @endforeach
</div>