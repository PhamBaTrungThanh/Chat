@extends('layouts.app')

@section('content')
<div class="standalone sign-up">
    <div class="panel is-responsive is-medium">
        <div class="content">
            <figure class="color-logo">
                <img src="images/users.png" alt="">
            </figure>
            <h2 class="has-text-centered">{{ __('Xin chào') }},</h2>
            <p class="is-size-5">
                Rất cám ơn bạn đã đăng ký làm thành viên của <a class="special-link" href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a>.
                Bạn có vui lòng cung cấp thêm một vài thông tin không?
            </p>
            <div class="field">
                <div class="control">
                    <h4>Ngày sinh</h4>
                    <b>Ngày</b>
                    <select name="day" id="day">
                        
                        @for($i = 1; $i <=31; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                    <span>&nbsp;</span><span>&nbsp;</span>
                    <b>Tháng</b>
                    <span>&nbsp;</span>
                    <select name="month" id="month">
                        @for($i = 1; $i <=12; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                    <span>&nbsp;</span><span>&nbsp;</span>
                    <b>Năm</b>
                    <span>&nbsp;</span>
                    <select name="year" id="year">
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
        </div>
    </div>
</div>
@endsection
@push('headend')
    <style>
        #avatar-image {
            width: 128px;
            height: 128px;
            object-fit: contain;
            border: 2px solid #ffffff;
            box-shadow: 0px 0px 0px 1px rgba(85, 85, 85, 0.2);
            border-radius: 50%;
            overflow: hidden;
        }
        #avatar-image[src=""] {
            display: none;
        }
        .avatar-display {
            margin: 0 !important;
        }
    </style>
@endpush
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