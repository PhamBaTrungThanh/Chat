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
        return view('splash');
    }
    public function wellcome()
    {
        if (!session()->get('new_user')) {
            //abort(500);
        }
        return view('users.wellcome')->with([
            "now" => date("Y"),
            "til" => date("Y") - 50
        ]);
    }
}
