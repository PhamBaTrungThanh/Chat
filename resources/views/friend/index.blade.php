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
            @foreach ($awaiting as $user)
                <article class="media">
                    <div class="media-left">
                        <p class="image is-64x64 avatar">
                            <img src="{{$user->avatarUrl}}" alt="Ảnh đại diện của {{$user->name}}">
                        </p>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                {!! __("friend.requestreceive", ["username" => $user->name]) !!}
                            </p>
                            <p>
                                <form action="{{route('user.friend.submit')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{$user->id}}">
                                    <button class="button is-link is-outlined" type="submit" name="action" value="ACCEPT">{{__("friend.accept")}}</button>
                                    <button class="button is-dark is-outlined" type="submit" name="action" value="REJECT">{{__("friend.reject")}}</button>
                                </form>
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="user-list">
                @foreach ($pending as $user)
                    <article class="media">
                        <div class="media-left">
                            <p class="image is-64x64 avatar">
                                <img src="{{$user->avatarUrl}}" alt="Ảnh đại diện của {{$user->name}}">
                            </p>
                        </div>
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    {!! __("friend.requestawait", ["username" => $user->name]) !!}
                                </p>
                                <p>
                                    <form action="{{route('user.friend.submit')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{$user->id}}">
                                        <button class="button is-danger is-outlined" type="submit" name="action" value="CANCEL">{{__("friend.cancel")}}</button>
                                    </form>
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
    @endif
</div>
@endpush