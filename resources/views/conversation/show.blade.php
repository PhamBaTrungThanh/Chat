@extends("layouts.app")

@section('content')
<section id="display_content" class="is-conversation is-{{$conversation->type}}" data-controller="conversation">
    <header>
        <p class="title">{{$conversation->name ?: $conversation->other->name}}</p>
    </header>
    <div class="content" data-target="conversation.content">

    </div>
    <div class="chatbar">
        <div class="chatbox">
            <div contenteditable="true" class="chatinput" 
                placeholder="Nhập..." 
                data-target="conversation.chatbox"
                data-action="keypress->conversation#keypress"></div>
        </div>
        <div class="chat-control">
            <a data-action="conversation#sendMessage"><b>Gửi</b></a>
        </div>
    </div>
</section>
@endsection