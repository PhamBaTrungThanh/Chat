<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()) {
            return redirect('/splash');
        }
        return view('home');
    }
    public function splash()
    {
        if (auth()->check()) {
            return redirect("/");
        }
        return view('splash');
    }
    public function wellcome(Request $request)
    {
        if (!session()->get('new_user')) {
            return redirect("/");
        }
        return view('users.wellcome')->with([
            "now" => date("Y"),
            "til" => date("Y") - 50
        ]);
    }
}
