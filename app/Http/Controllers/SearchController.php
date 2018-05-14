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
        return view('search.index');
    }
    public function submit(Request $request)
    {
        $request->validate([
            'searchbox' => "required",
        ]);
        $result = false;

        $result = User::setEagerLoads([])
                ->where("id" , "<>", auth()->user()->id)
                ->where(function ($query) use ($request) {
                    $query->where("email", $request->searchbox)
                          ->orWhere("name", "like", "%{$request->searchbox}%");
                })
                ->get();
        return redirect()->route("search.result")->with(["result" => $result]);

    }
    public function result(Request $request)
    {
        return view('search.index')->with(["result" => session('result')]);
    }
}
