<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" role="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- userId -->
    <meta name="user-id" content="{{auth()->user()->id}}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
    @stack('headend')
</head>
<body data-controller="chatt" data-action="notification->chatt#parseNotification">
    <div id="app">
        <main>
            <div class="content main-content with-sidebar">
                @include("components.sidebar")
                @yield("content")
            </div>
        </main>
    </div>
    @stack('bodyend')
</body>
</html>
