<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
class FriendController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function index(Request $request)
    {
        $list = auth()->user()->getAllFriendships();
        $userId = auth()->user()->id;
        $queries = [];
        list($pendingFriends, $friends, $rejectFriends, $blockedFriends) = array([],[],[],[]);
        foreach ($list as $friendship) {
            $actor = ($userId === $friendship->sender_id) ? $friendship->recipient_id : $friendship->sender_id;
            $queries[] = $actor;
            switch ($friendship->status) {
                case 0:
                    # PENDING
                    $pendingFriends[] = $actor;
                    break;
                case 1:
                    # PENDING
                    $friends[] = $actor;
                    break;
                case 2:
                    # PENDING
                    $rejectFriends[] = $actor;
                    break;
                case 3:
                    # PENDING
                    $blockedFriends[] = $actor;
                    break;

                default:
                    # code...
                    break;
            }
        }
        $users = User::whereIn('id', $queries)->get();
        return view('friend.index')->with([
            "pending" => $users->filter(function ($node) use ($pendingFriends){
                return in_array($node->id, $pendingFriends);
            }),
            "friends" => $users->filter(function ($node) use ($friends){
                return in_array($node->id, $friends);
            }),
            "rejects" => $users->filter(function ($node) use ($rejectFriends){
                return in_array($node->id, $rejectFriends);
            }),
        ]);
    }
    public function add(Request $request, User $friend)
    {
        if (auth()->user()->hasSentFriendRequestTo($friend)) {
            session()->flash("alert", __("friend.requestalredysent"));
            session()->flash("alert_type", "is-warning");
        } else {
            auth()->user()->befriend($friend);
            session()->flash("alert", __("friend.requestsent"));
        }
        return back()->withInput();
    }
    public function accept(Request $request, User $friend)
    {
        if (auth()->user()->isFriendWith($friend)) {
            session()->flash("alert", __("friend.alreadyfriend"));
            session()->flash("alert_type", "is-warning");
        } else {
            auth()->user()->acceptFriendRequest($friend);
            session()->flash("alert", __("friend.befriend"));
        }
        return back()->withInput();
    }
    public function cancel(Request $request, User $friend)
    {
        $friend->denyFriendRequest(auth()->user());
        session()->flash("alert", __("friend.cancel"));
        return back()->withInput();
    }
}
