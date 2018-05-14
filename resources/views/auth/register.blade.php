@extends('layouts.page')

@section('content')
<div class="standalone sign-up">
    <div class="panel is-responsive is-medium">
        <div class="content">
            <figure class="color-logo image">
                <img src="images/color-logo.png" alt="">
            </figure>
            <h2 class="has-text-centered">{{ __('Đăng ký') }}</h2>
            @include('auth.register-form')
            <h3 class="has-text-centered"><a href="{{ route('login') }}" class="">{{__('Quay về trang đăng nhập')}}</a></h3>
        </div>
    </div>

</div>
@endsection
