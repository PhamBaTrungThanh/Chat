<div class="user-list">
    @foreach($users as $user)
        <div class="user-card">
            <div class="card-content">
                <figure class="avatar image user-avatar">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name}}'s Avatar'">
                </figure>
                <p class="user-name has-text-centered has-text-strong">
                    {{$user->name}}
                </p>
                @if (!in_array($user->id, $pending))
                    <div class="buttons is-centered">
                        <form action="{{route('user.friend.add', $user->id)}}" method="post">
                            @csrf
                            <button class="button is-primary" type="submit">{{__("friend.add")}}</button>
                        </form>
                    </div>
                @elseif (in_array($user->id, $awaiting))
                    <div class="buttons is-centered">
                        <form action="{{route('user.friend.accept', $user->id)}}" method="post">
                            @csrf
                            <button class="button is-link" type="submit">{{__("friend.accept")}}</button>
                        </form>
                    </div>                            
                @else
                <div class="buttons is-centered">
                        <button class="button" disabled>{{__("friend.alreadyadd")}}</button>
                        <form action="{{route('user.friend.cancel', $user->id)}}" method="post">
                            @csrf
                            <button class="button is-danger is-outlined" type="submit">{{__("friend.cancel")}}</button>
                        </form>
                    </div>                            
                @endif
            </div>
        </div>
    @endforeach
</div>