@extends('layouts.app')

@section('content')
<div class="standalone wellcome">
    <div class="panel is-responsive is-medium">
        <div class="content">
            <figure class="color-logo">
                <img src="images/users.png" alt="">
            </figure>
            <h2 class="has-text-centered">{{ __('Xin chào') }}, {{auth()->user()->name}}</h2>
            <p class="is-size-5">
                Rất cám ơn bạn đã đăng ký làm thành viên của <a class="special-link" href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a>.
                Bạn có vui lòng cung cấp thêm một vài thông tin không?
            </p>
            <p class="subtitle is-6 is-italic">
                (Bạn có thể thay đổi thông tin bất cứ lúc nào.)
            </p>
            <form method="POST" action="{{ route('user.update', auth()->user())}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT" />
                <input type="hidden" name="wellcome_update" value="true" />
                <div class="field">
                    <div class="control">
                        <h4>Giới tính</h4>
                        <div class="level gender-selector">
                            <div class="level-item">
                                <input type="radio" name="gender" value="male" id="gender_male" checked="checked"  class="visually-hidden">
                                <label for="gender_male" class="choose-gender">
                                    <figure class="image is-128x128">
                                        <img src="{{asset('images/boy.png')}}" />
                                    </figure>
                                </label>
                            </div>
                            <div class="level-item">
                                <input type="radio" name="gender" value="female" id="gender_female"  class="visually-hidden">
                                <label for="gender_female" class="choose-gender">
                                        <figure class="image is-128x128">
                                            <img src="{{asset('images/girl.png')}}" />
                                        </figure>
                                    </label>
                            </div>
                        </div>
                        

                    </div>
                    <div class="control">
                        <h4>Ngày sinh</h4>
                        <b>Ngày</b>
                        <select name="day" id="day">
                            <option selected disabled>Chọn ngày</option>
                            @for($i = 1; $i <=31; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <span>&nbsp;</span><span>&nbsp;</span>
                        <b>Tháng</b>
                        <span>&nbsp;</span>
                        <select name="month" id="month">
                            <option selected disabled>Chọn tháng</option>
                            @for($i = 1; $i <=12; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <span>&nbsp;</span><span>&nbsp;</span>
                        <b>Năm</b>
                        <span>&nbsp;</span>
                        <select name="year" id="year">
                                <option selected disabled>Chọn năm</option>
                            @for ($i = $now; $i >= $til; $i--)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>                   
                    </div>
                    <div class="control">
                        <h4>{{__("Ảnh đại diện")}}</h4>
                        <input type="file" name="avatar" id="avatar" class="visually-hidden" accept="image/*">
                        <figure class="avatar-display">
                            <img src="" id="avatar-image">
                        </figure>
                        <label for="avatar" class="has-text-centered button is-link">
                            {{__("Tải ảnh lên")}}
                        </label>
                    </div>
                    @if (count($errors->all() > 0))
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
                            <button class="is-primary button">{{__('Tiếp tục')}}</button>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="level-item">
                            <a href="{{env('APP_URL')}}?skip=1">{{__('Không, cảm ơn.')}}</a>
                        </div>      
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('bodyend')
    <script language="javascript">
        (function() {
            var avatarFile = document.getElementById("avatar");
            var avatarImage = document.getElementById("avatar-image");
            avatarFile.addEventListener("change", function() {
                var fileReader = new FileReader();
                fileReader.onload = function () {
                    var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
                    avatarImage.src = data;
                }
                fileReader.readAsDataURL(avatarFile.files[0]);
            })
        })(window)
    </script>
@endpush