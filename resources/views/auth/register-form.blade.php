<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="field">
        <div class="control with-icon">
            <input type="text"  class="input {{ $errors->has('new_email') ? 'is-invalid' : '' }}" name="new_email" id="new_email" placeholder="Email"  value="{{ old('new_email') }}">
            <span class="icon">
                <i class="icon-mail"></i>
            </span>
        </div>
        <div class="control with-icon">
            <input type="password" class="input" name="new_password" id="new_password" placeholder="Mật khẩu">
            <span class="icon">
                <i class="icon-key"></i>
            </span>
        </div>
        <div class="control with-icon">
            <input type="password" class="input" name="new_password_confirmation" id="new_password_confirmation" placeholder="Xác nhận mật khẩu">
            <span class="icon">
                <i class="icon-key"></i>
            </span>
        </div>
        <div class="control with-icon">
                <input type="text" class="input {{ $errors->has('new_name') ? 'is-invalid' : '' }}" name="new_name" id="new_name" placeholder="Tên của bạn"  value="{{ old('new_name') }}">
                <span class="icon">
                    <i class="icon-user-o"></i>
                </span>
            </div>
        <div class="control">
            <input type="checkbox" name="terms_and_conditions" id="terms_and_conditions" class="{{ $errors->has('terms_and_conditions') ? 'is-invalid' : '' }}">
            <label for="terms_and_conditions">
                <span class="icon">
                    <i class="icon-check"></i>
                </span>
                Tôi đồng ý và sẽ tuân thủ những quy định của <a class="special-link">{{env('APP_NAME')}}</a>
            </label>
        </div>
        @if (count($errors->all()) > 0 && Route::currentRouteName() !== "login")
            @foreach($errors->all() as $message)
                <p class="help">
                    {{ $message }}
                </p>
            @endforeach
        @endif
    </div>
    <div class="level">
        <div class="level-left">
            <div class="level-item">
                <button type="submit" value="Đăng ký" class="button has-icon is-medium">
                    <span>Xác nhận</span>
                    <span class="icon">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </button>
            </div>
        </div>
        @if(active("register"))
            <div class="level-right">
                <div class="level-item">
                    <a href="{{ route('login') }}" class=" is-hidden-touch">{{__('Quay về trang đăng nhập')}}</a>
                </div>
            </div>
        @endif
    </div>

</form>