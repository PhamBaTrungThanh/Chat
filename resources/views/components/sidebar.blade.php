<section role="sidebar" id="main__sidebar">
    <div id="user__info" class="is-hidden-touch">
        <h4 class="has-text-centered name">{{auth()->user()->name}}</h4>
        <figure class="image avatar">
            <img src="{{auth()->user()->avatarUrl}}" alt="User avatar">
        </figure>
    </div>
    <div id="waves" class="is-hidden-touch">
        <div class="wave wave--1"></div>
        <div class="wave wave--2"></div>
        <div class="wave wave--3"></div>
    </div>
    <div id="sidebar__content" class="">
        <div id="sidebar__menu">
            <a class="chat-icon is-hidden-desktop toogle-sidebar" data-action="chatt#toggleSidebar">
                <span class="icon">
                    <i class="icon-menu"></i>
                </span>
            </a>
            <a href="{{route('index')}}" class="{{active('conversation.*')}} chat-icon">
                <span class="icon">
                    <i class="icon-chat"></i>
                </span>
            </a>
            <a href="{{route('search')}}" class="{{active('search')}}">
                    <span class="icon">
                        <i class="icon-search"></i>
                    </span>                       
                </a>
            <a href="{{route('user.friend.index')}}" class="{{active('user.friend.*')}}">
                <span class="icon with-notification">
                    <i class="icon-users"></i>
                    <span class="notification" data-target="chatt.friendNotification" style="display: {{auth()->user()->friendRequestNotifications->count() === 0 ? "none" : "block"}}"></span>
                </span>                  
            </a>
            <a href="#settings" class="setting-icon {{active('settings.*')}}">
                <span class="icon">
                    <i class="icon-cog"></i>
                </span>                       
            </a>
        </div>
        @stack('sidebar__display')
    </div>
</section>