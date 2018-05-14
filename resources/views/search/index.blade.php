@extends('layouts.app')

@section('content')
<section role="searchbox" id="display_content">
    <form action="{{route('search.submit')}}" method="post">
        @csrf
        <div class="field">
            <div class="control is-large is-bordered">
                <input type="text" class="input" placeholder="@lang('search.placeholder')" name="searchbox" required>
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
    @isset($result)
        <p class="title has-text-centered">
            {!! trans_choice('search.result', count($result), ['value' => count($result)]) !!}
        </p>
        <div class="search-result">
            @foreach($result as $user)
                <div class="user-card">
                    <div class="card-content">
                        <figure class="avatar image user-avatar">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name}}'s Avatar'">
                        </figure>
                        <p class="user-name has-text-centered has-text-strong">
                            {{$user->name}}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endisset
</section>
@endsection
