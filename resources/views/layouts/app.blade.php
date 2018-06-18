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
    <meta name="user-avatar" content="{{ auth()->user()->avatarUrl }}">
    <meta name="user-name" content="{{ auth()->user()->name }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('headend')
</head>
<body data-controller="chatt" data-action="notification->chatt#parseNotification" data-chatt-friend-notifications-count="{{auth()->user()->friendRequestNotifications->count()}}">
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
