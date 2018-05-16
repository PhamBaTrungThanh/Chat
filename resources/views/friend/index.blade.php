@extends('layouts.app')

@section('content')
<section id="display_content">
    <header>
        <p class="title">Danh sách bạn bè</p>
    </header>
    <div class="content">
        @if (count($friends) === 0)
        @else
            @include('components.usercards', ['users' => $friends])
        @endif
    </div>
</section>
@endsection

@push("sidebar__display")

<div id="sidebar__display">

    @if (count($pending) > 0)
        <h5>Lời mời kết bạn</h4>    
        <div class="user-list">
            @foreach ($pending as $user)
                <article class="media">
                    <div class="media-left">
                        <p class="image is-64x64">
                            <img src="{{$user->avatarUrl}}" alt="Ảnh đại diện của {{$user->name}}">
                        </p>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                {!! __("friend.befriend", ["username" => $user->name]) !!}
                            </p>
                            <p>
                                <button class="button is-link is-outlined" type="submit">{{__("friend.accept")}}</button>
                                <button class="button is-dark is-outlined" type="submit">{{__("friend.reject")}}</button>
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endpush