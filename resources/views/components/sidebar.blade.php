<section role="sidebar" id="main__sidebar">
    <div id="user__info">
        <h4 class="has-text-centered name">{{auth()->user()->name}}</h4>
        <figure class="image avatar">
            <img src="{{auth()->user()->avatarUrl}}" alt="User avatar">
        </figure>
    </div>
    <div id="waves" class=" is-hidden-touch">
        <div class="wave wave--1"></div>
        <div class="wave wave--2"></div>
        <div class="wave wave--3"></div>
    </div>
    <div id="sidebar__content" class="">
        <div id="sidebar__menu">
            <a href="{{route('index')}}" class="{{active('index')}} chat-icon">
                <span class="icon">
                    <i class="far fw fa-comment-alt"></i>
                </span>
            </a>
            <a href="{{route('user.friend.index')}}" class="{{active('user.friend.*')}}">
                <span class="icon">
                    <i class="fas fw fa-user-friends  "></i>
                </span>                       
            </a>
            <a href="#settings" class="setting-icon {{active('settings.*')}}">
                <span class="icon">
                    <i class="fas fw fa-cog"></i>
                </span>                       
            </a>
        </div>
        @stack('sidebar__display')
    </div>
</section>