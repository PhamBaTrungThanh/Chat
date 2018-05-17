<div class="columns is-centered">
    @foreach($users as $user)
        <div class="column is-half-table is-one-quarter-desktop user-card">
            <div class="card-content content">
                <figure class="avatar image user-avatar">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name}}'s Avatar'">
                </figure>
                <p class="user-name has-text-centered has-text-strong">
                    {{$user->name}}
                </p>
                <form action="{{route('user.friend.submit')}}" method="post">
                    @csrf
                    <input type="hidden" name="friend_id" value="{{$user->id}}">
                    @if ($user->status === "FRIEND")
                        <div class="buttons is-centered">
                            <a class="button is-link" href="#">{{__("Trò chuyện")}}</a>
                        </div>
                    @elseif ($user->status === "AWAITING")
                        <div class="buttons is-centered">
                            <button class="button is-link" type="submit" name="action" value="ACCEPT">{{__("friend.accept")}}</button>
                            <button class="button is-danger is-outlined" type="submit" name="action" value="REJECT">{{__("friend.reject")}}</button>
                        </div>                            
                    @elseif ($user->status === "PENDING")
                        <div class="buttons is-centered">
                            <button class="button" disabled>{{__("friend.alreadyadd")}}</button>
                            <button class="button is-danger is-outlined" type="submit" name="action" value="CANCEL">{{__("friend.cancel")}}</button>
                        </div>            
                    @else
                        <div class="buttons is-centered">
                            <button class="button is-primary" type="submit" name="action" value="ADD">{{__("friend.add")}}</button>
                        </div>                                
                    @endif
                </form>
            </div>
        </div>
    @endforeach
</div>