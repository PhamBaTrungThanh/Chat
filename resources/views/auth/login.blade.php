@extends('layouts.page')

@section('content')
<div class="login-container">
    <div class="login-panel content">
        <div class="sign-in primary-background">
            <figure class="color-logo on-mobile is-hidden-desktop image">
                <img src="images/color-logo.png" alt="">
            </figure>
            <div class="padding-container is-hidden-touch"></div>
            <h3 class="has-text-centered has-text-light">{{ __('Đăng nhập') }}</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field with-triangle">
                    <div class="control with-icon">
                        <input type="text" class="input {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autofocus>
                        <span class="icon">
                            <i class="fas fa-user-circle"></i>
                        </span>
                    </div>
                    <div class="control with-icon">
                        <input type="password" class="input {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" id="password" placeholder="{{ __('Mật khẩu') }}" required>
                        <span class="icon">
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                    @if ($errors->has('email'))
                        <p class="help">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                    @if ($errors->has('password'))
                        <p class="help">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
                <p>
                    <input type="submit" value="{{ __('Đăng nhập') }}" class="button login-submit">
                </p>
                <h6>
                    <a class="is-primary" href="{{ route('password.request') }}">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                </h6>
                <h6 class="is-hidden-desktop">
                    <a class="is-link" href="{{ route('register') }}">
                        {{ __('Đăng ký') }}
                    </a>
                </h6>
            </form>
        </div>
        <div class="separator is-hidden-touch">
            <figure class="color-logo image">
                <img src="images/color-logo.png" alt="">
            </figure>
        </div>
        <div class="sign-up is-hidden-touch">
            <div class="padding-container is-hidden-touch"></div>
            <h3 class="has-text-centered">Đăng ký</h3>
            @include('auth.register-form')
        </div>

    </div>
</div>
@endsection
