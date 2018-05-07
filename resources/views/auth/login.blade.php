@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-panel">
        <div class="sign-in dark-background">
            <h3 class="has-text-centered">{{ __('Đăng nhập') }}</h3>
            <div class="field with-triangle">
                <div class="control with-icon">
                    <input type="text" class="input" name="email" id="email" placeholder="Email">
                    <span class="icon">
                        <i class="fas fa-user-circle"></i>
                    </span>
                </div>
                <div class="control with-icon">
                    <input type="password" class="input" name="password" id="password" placeholder="Mật khẩu">
                    <span class="icon">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="separator hide-on-mobile">
            <figure class="color-logo">
                <img src="images/color-logo.png" alt="">
            </figure>
        </div>
        <div class="sign-up white-background">
            <h3 class="has-text-centered">Đăng ký</h3>
            <div class="field">
                <div class="control">
                    <input type="text" class="input" name="new_email" id="new_email" placeholder="Email">
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
