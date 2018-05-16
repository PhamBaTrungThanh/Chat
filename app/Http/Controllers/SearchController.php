<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }


    public function searching(Request $request)
    {
        $request->validate([
            "searchbox" => "required",
        ]);
        return redirect()->route('search.result', ["query" => $request->input("searchbox")]);
    }
    public function result(Request $request, string $q)
    {
        list($awaiting, $friends, , $blocked, $pending) = auth()->user()->relationshipsIds;
        $result = User::setEagerLoads([])
                ->where("id" , "<>", auth()->user()->id)
                ->whereNotIn("id", $request->user()->getFriends()->pluck('id'))
                ->where(function ($query) use ($q) {
                    $query->where("email", $q)
                          ->orWhere("name", "like", "%{$q}%");
                })
                ->get();
        $result->each(function ($user) use ($awaiting, $friends, $blocked, $pending) {
            if (in_array($user->id, $awaiting)) {
                $user->status = "AWAITING";
            } else if (in_array($user->id, $friends)) {
                $user->status = "FRIEND";
            } else if (in_array($user->id, $blocked)) {
                $user->status = "BLOCKED";
            } else if (in_array($user->id, $pending)) {
                $user->status = "PENDING";
            }
            return $user;
        });
        return view('search.index')->withResult($result)->withQuery($q);
    }

}
