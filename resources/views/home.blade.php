@extends('layouts.app')

@section('content')
    <div class="content main-content with-sidebar">
        <section role="sidebar" id="main__sidebar">
            <div id="user__info">
                <h4 class="has-text-centered name">{{auth()->user()->name}}</h4>
                <figure class="image avatar">
                    <img src="{{auth()->user()->avatarUrl}}" alt="User avatar">
                </figure>
            </div>
            <div id="waves">
                <div class="wave wave--1"></div>
                <div class="wave wave--2"></div>
                <div class="wave wave--3"></div>
            </div>
            <div id="sidebar__content" class="">
                <div id="sidebar__menu">
                    <a href="{{route('index')}}" class="{{active('index')}} chat-icon">
                        <span class="icon">
                            <i class="far fw fa-comment-alt"></i>
                        </span>
                    </a>
                    <a href="#search" class="setting-icon {{active('settings')}}">
                        <span class="icon">
                            <i class="fas fw fa-search "></i>
                        </span>                       
                    </a>
                    <a href="#settings" class="setting-icon {{active('settings')}}">
                        <span class="icon">
                            <i class="fas fw fa-cog"></i>
                        </span>                       
                    </a>
                </div>
                <div id="sidebar__conversations" class="@if (auth()->user()->conversations_count === 0) no-conversation @endif">
                        @if (auth()->user()->conversations_count === 0) 
                            <div class="find-more">
                                <p class="has-text-centered title is-5">
                                    <span class="icon">
                                        <i class="fas fa-arrow-up"></i>
                                    </span>
                                </p>
                                <p class="has-text-centered subtitle">
                                    {{__("Thêm bạn")}}
                                </p>
                            </div>
                            <p class="has-text-centered is-size-4">{{__("Bạn chưa có cuộc trò chuyện nào.")}}</p>
                        @endif
                </div>
            </div>
        </section>
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
