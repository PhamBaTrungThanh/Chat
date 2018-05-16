@extends('layouts.app')

@section('content')
<section id="display_content">
    <header>
            <p class="title">@lang("Tìm kiếm")</p>
    </header>
    <form action="{{route('search.searching')}}" method="POST">
        @csrf
        <div class="field is-marginless">
            <div class="control is-large is-bordered">
                <input type="text" class="input" placeholder="@lang('search.placeholder')" name="searchbox" required value="@isset($query){{$query}}@endisset">
            </div>
            <div class="control button-group">
                <button type="submit" class="button has-icon is-medium">
                    <span>@lang("search.button")</span>
                    <span class="icon">
                        <i class="fas fa-search"></i>
                    </span>
                </button>
            </div>
        </div>
    </form>
    @if (session('alert'))
        <div class="notification @if(session('alert_type')){{session('alert_type')}}@endif">
            <button class="delete"></button>
            {{ session('alert') }}
        </div>
    @endif
    @isset($result)
        <p class="title has-text-centered">
            {!! trans_choice('search.result', count($result), ['value' => count($result)]) !!}
        </p>
        @include('components.usercards', ['users' => $result]);
    @endisset
</section>
@endsection
