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

    public function index()
    {
        list($pending, $awaiting) = auth()->user()->generateFriendsRelationships();
        return view('search.index')->with([
            "result" => session('result'),
            "pending" => $pending,
            "awaiting" => $awaiting,
        ]);
    }
    public function submit(Request $request)
    {
        $request->validate([
            'searchbox' => "required",
        ]);
        $result = User::setEagerLoads([])
                ->where("id" , "<>", auth()->user()->id)
                ->whereNotIn("id", $request->user()->getFriends()->pluck('id'))
                ->where(function ($query) use ($request) {
                    $query->where("email", $request->searchbox)
                          ->orWhere("name", "like", "%{$request->searchbox}%");
                })
                ->get();
        return redirect()->route("search.index")->with(["result" => $result])->withInput();

    }

}
