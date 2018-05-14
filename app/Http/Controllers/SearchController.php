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
        // first we query the email
        if (filter_var($request->searchbox, FILTER_VALIDATE_EMAIL)) {
            if ($request->searchbox !== auth()->user()->email) {
                $result = User::where("email", $request->searchbox)->limit(1)->get();
            }
        }
        if (!$result) {
            $result = User::where("name", "like", "%{$request->searchbox}%")
                            ->where("id" , "<>", auth()->user()->id)
                            ->get();
        }
        return redirect()->route("search.result")->with(["result" => $result]);

    }
    public function result(Request $request)
    {
        return view('search.index')->with(["result" => session('result')]);
    }
}
