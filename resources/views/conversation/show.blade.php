@extends("layouts.app")

@section('content')
<section id="display_content" class="is-conversation is-{{$conversation->type}}" data-controller="conversation" data-conversation-post-url="{{route('conversation.message', $conversation)}}">
    <header>
        <p class="title">{{$conversation->name ?: $conversation->other->name}}</p>
    </header>
    <div class="content" data-target="conversation.content">
        @if(count($messages) > 0)
            @foreach($messages as $message)
                <div class="message {{($message->user_id === auth()->user()->id) ? 'self' : ''}}" >{{$message->body}}</div>
            @endforeach
        @endif
    </div>
    <div class="chatbar">
        <div class="chatbox">
            <div contenteditable="true" class="chatinput" 
                placeholder="Nhập..." 
                data-target="conversation.chatbox"
                data-action="keypress->conversation#keypress"></div>
        </div>
        <div class="chat-control">
            <a data-action="conversation#sendMessage" class="send-button">
                <span class="icon"><i class="icon-send-message"></i></span>
            </a>
        </div>
    </div>
</section>
@endsection

@push("sidebar__display")
    @include("conversation.sidebar")
@endpush