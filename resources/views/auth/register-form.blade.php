<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="field">
        <div class="control with-icon">
            <input type="text" class="input" name="new_email" id="new_email" placeholder="Email">
            <span class="icon">
                <i class="fas fa-envelope"></i>
            </span>
        </div>
        <div class="control with-icon">
            <input type="password" class="input" name="new_password" id="new_password" placeholder="Mật khẩu">
            <span class="icon">
                <i class="fas fa-key"></i>
            </span>
        </div>
        <div class="control">
            <input type="checkbox" name="terms_and_conditions" id="terms_and_conditions">
            <label for="terms_and_conditions">
                <span class="icon">
                    <i class="fas fa-check-circle"></i>
                </span>
                Tôi đồng ý và sẽ tuân thủ những quy định của <a class="special-link">Chatt</a>
            </label>
        </div>
    </div>
    <button type="submit" value="Đăng ký" class="button has-icon is-medium">
        <span>Xác nhận</span>
        <span class="icon">
            <i class="fas fa-arrow-right"></i>
        </span>
    </button>
</form>