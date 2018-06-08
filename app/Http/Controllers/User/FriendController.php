<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\FriendRequested;
use App\Notifications\FriendAccepted;
use App\Notifications\FriendRejected;
use App\Notifications\FriendRequestCanceled;
use App\Notifications\BeFriendWith;
class FriendController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function submit(Request $request) 
    {
        $request->validate([
            "friend_id" => "required|integer",
            "action" => "required",
        ]);
        $friend = User::find($request->input('friend_id'));
        $user = auth()->user();
        switch ($request->input('action')) {
            case 'ADD':
                if ($user->hasSentFriendRequestTo($friend)) {
                    session()->flash("alert", __("friend.request.alredysent", ["username" => $friend->name]));
                    session()->flash("alert_type", "is-warning");
                } else {
                    $friend->notify(new FriendRequested($user));
                    $user->befriend($friend);
                    session()->flash("alert", __("friend.request.sent", ["username" => $friend->name]));
                }
                break;
            case 'ACCEPT':
                if ($user->isFriendWith($friend)) {
                    session()->flash("alert", __("friend.alreadyfriend", ["username" => $friend->name]));
                    session()->flash("alert_type", "is-warning");
                } else {
                    $user->acceptFriendRequest($friend);
                    $user->notifications()->where("data->friend->id", $friend->id)
                                          ->where("type", FriendRequested::class)->delete();
                    $friend->notify(new FriendAccepted($user));
                    $user->notify(new FriendAccepted($friend));
                    session()->flash("alert", __("friend.befriend", ["username" => $friend->name]));
                }
                break;
            case 'CANCEL':
                if ($user->hasSentFriendRequestTo($friend)) {
                    $friend->notifications()->where("data->friend->id", $user->id)
                                          ->where("type", FriendRequested::class)->delete();
                    $friend->notify(new FriendRequestCanceled($user));
                    $user->cancelFriendRequest($friend);
                    session()->flash("alert", __("friend.request.canceled", ["username" => $friend->name]));
                }
                break;
            case 'DENY':
                    $user->denyFriendRequest($friend);
                    session()->flash("alert", __("friend.request.denied", ["username" => $friend->name]));
                break;
            case 'BLOCK':
                $user->blockFriend($friend);
                session()->flash("alert", __("friend.request.blocked", ["username" => $friend->name]));
                break;  
            case 'UNBLOCK':
                $user->unblockFriend($friend);
                session()->flash("alert", __("friend.request.unblocked", ["username" => $friend->name]));
                break;                                       
            default:
                # code...
                break;
        }
        return back();

    }
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        auth()->user()->friendRequestNotifications;
        list($awaiting, $friends, $rejected, $blocked, $pending) = auth()->user()->allRelationshipModels;
        return view('friend.index')->with([
            "pending" => $pending,
            "awaiting" => $awaiting,
            "friends" => $friends,
            "rejects" => $rejected,
        ]);
    }

    public function ajaxSidebar(Request $request)
    {
        $userId = auth()->user()->id;
        auth()->user()->friendRequestNotifications;
        list($awaiting, $friends, $rejected, $blocked, $pending) = auth()->user()->allRelationshipModels;
        return view('friend.sidebar')->with([
            "pending" => $pending,
            "awaiting" => $awaiting,
            "friends" => $friends,
            "rejects" => $rejected,
        ]);
    }
}
