<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
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
        $latest = auth()->user()->conversations()->latest("updated_at")->first();
        if ($latest) {
            return redirect()->route("conversation.show", $latest);
        }
        else {
            return view("home");
        }
        
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
