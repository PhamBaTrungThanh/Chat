@extends('layouts.app')

@section('content')
    <div class="content main-content with-sidebar">
        @include("components.sidebar")
        <section role="chatbox" id="main__chatbox">
            @if (auth()->user()->conversations_count === 0)
                <div class="no-conversation is-hidden-touch">
                    <div>
                        <p class="has-text-centered is-size-4">{{__("Bạn chưa có cuộc trò chuyện nào.")}}</p>
                        <p class="has-text-centered is-size-4">{{__("Hãy tìm kiếm để thêm bạn và bắt đầu một cuộc trò chuyện nhé.")}}</p>
                    </div>

                </div>
            @endif            
        </section>
    </div>

@endsection
