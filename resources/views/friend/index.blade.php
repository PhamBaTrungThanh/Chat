@extends('layouts.app')

@section('content')
<section role="searchbox" id="display_content">

</section>
@endsection

@push("sidebar__display")
<div id="sidebar__display">

    @if ($pending->count() > 0)
        <h4>Lời mời kết bạn</h4>    
        <div class="">
            @foreach ($pending as $user)
                <div class="notification">
                    <a href="" class="delete"></a>
                    <div class="user__avatar">
                        <figure class="avatar image">
                            <img src="{{$user->avatarUrl}}" alt="Ảnh đại diện của {{$user->name}}">
                        </figure>
                    </div>
                    <div class="user-list__item__content">
                        <p>
                            {{$user->name}}
                        </p>
                            <button class="button is-link" type="submit">{{__("friend.accept")}}</button>
                    </div>

                </div>
                
            @endforeach
        </div>
    @endif
</div>
@endpush