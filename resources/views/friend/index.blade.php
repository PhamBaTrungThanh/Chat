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
    @include("friend.sidebar")
@endpush