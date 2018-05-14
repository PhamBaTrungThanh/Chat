@extends('layouts.app')

@section('content')

<section role="chatbox" id="display_content">
    @if (auth()->user()->conversations_count === 0)
        <div class="no-conversation">
            <div>
                <p class="has-text-centered is-size-4">{{__("Bạn chưa có cuộc trò chuyện nào.")}}</p>
                <p class="has-text-centered is-size-4">{{__("Hãy tìm kiếm để thêm bạn và bắt đầu một cuộc trò chuyện nhé.")}}</p>
            </div>

        </div>
    @endif            
</section>
@endsection

@push("sidebar__display")
<div id="sidebar__display">
    @if (auth()->user()->conversations_count === 0) 
        <div class="no-conversation is-hidden-touch">
            <p class="has-text-centered is-size-4">{{__("Bạn chưa có cuộc trò chuyện nào.")}}</p>
        </div>
        <div class="find-more is-hidden-touch">
            <p class="has-text-centered title is-5">
                <span class="icon">
                    <i class="fas fa-arrow-up"></i>
                </span>
            </p>
            <p class="has-text-centered subtitle">
                {{__("Thêm bạn")}}
            </p>
        </div>
    @endif
</div>
@endpush