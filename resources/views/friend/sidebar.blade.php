<div id="sidebar__display" data-controller="friends--sidebar" data-friends--sidebar-url="{{route('user.friend.sidebar')}}" data-target="chatt.friendsRequestArea" data-action="rebuild->friends--sidebar#load">
    @if (count(auth()->user()->newFriends) > 0)
        <div class="user-list">
            @foreach(auth()->user()->newFriends as $friend)
                <article class="media is-highlight is-relative"  data-controller="dismissable"  data-dismissable-update-url="{{route('user.notification.read', ['notification_id' => $friend->notification_id])}}">
                    <div class="media-left">
                        <p class="image is-64x64 avatar">
                            <img src="{{$friend->avatarUrl}}" alt="Ảnh đại diện của {{$friend->name}}">
                        </p>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                {!! __("friend.befriend", ["username" => $friend->name]) !!}
                            </p>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="media-right">
                        <div class="media-right">
                            <button class="delete"data-action="dismissable#fire"></button>
                        </div>
                    </div>
                </article>                
            @endforeach           
        </div>
    @endif
    @if (count($pending) > 0 || count($awaiting) > 0)
        <h5>Lời mời kết bạn</h5>    
        <div class="user-list">
            @foreach ($awaiting as $user)
                <article class="media">
                    <div class="media-left">
                        <p class="image is-64x64 avatar">
                            <img src="{{$user->avatarUrl}}" alt="Ảnh đại diện của {{$user->name}}">
                        </p>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                {!! __("friend.request.received", ["username" => $user->name]) !!}
                            </p>
                            <div>
                                <form action="{{route('user.friend.submit')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{$user->id}}">
                                    <button class="button is-link is-outlined" type="submit" name="action" value="ACCEPT">{{__("friend.accept")}}</button>
                                    <button class="button is-dark is-outlined" type="submit" name="action" value="REJECT">{{__("friend.reject")}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="user-list">
                @foreach ($pending as $user)
                    <article class="media">
                        <div class="media-left">
                            <p class="image is-64x64 avatar">
                                <img src="{{$user->avatarUrl}}" alt="Ảnh đại diện của {{$user->name}}">
                            </p>
                        </div>
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    {!! __("friend.request.await", ["username" => $user->name]) !!}
                                </p>
                                <p>
                                    <form action="{{route('user.friend.submit')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{$user->id}}">
                                        <button class="button is-danger is-outlined" type="submit" name="action" value="CANCEL">{{__("friend.cancel")}}</button>
                                    </form>
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
    @endif
</div>