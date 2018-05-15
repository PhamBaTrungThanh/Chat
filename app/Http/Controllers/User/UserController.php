<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Events\UserUploadAvatar;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
class UserController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->filled('wellcome_update')) {
            $request->validate([
                "day" => "required_with:month,year|integer",
                "month" => "required_with:day,year|integer",
                "year" => "required_with:day,month|integer",
                "avatar" => "sometimes|nullable|image",
                "gender" => "required",
            ]);

            // if user uploaded a file 
            if ($request->hasFile('avatar')) {
                // If it valid
                if ($request->file('avatar')->isValid()) {
                    //if (env('APP_DEBUG') === true) { 
                    if (false) {
                        $path = $request->file('avatar')->store('avatars');
                        $user->avatar = asset($path);
                    } else {
                        //event(new UserUploadAvatar($user, $request->file('avatar')->getPathname()));
                        $debug = (env('APP_DEBUG')) ? "debug/" : "";
                        $cloudder = Cloudder::upload($request->file('avatar')->getPathname(), "{$debug}__user-{$user->id}__avatar");
                        $result = Cloudder::getResult();
                        $user->avatar = $result['url'];
                    }
                }
            }
            // if user update their birthday
            if ($request->filled('day')) {
                $birthday = Carbon::createFromDate($request->input('year'), $request->input('month'), 1);
                // compare to day
                $birth_day = ($birthday->daysInMonth < (int) $request->input('day')) ? $birthday->daysInMonth : $request->input('day');
                $birthday->day($birth_day);
                $user->birthday = $birthday;
            }
            // set user gender
            $user->gender = $request->input('gender');

            $user->save();
            return redirect("/")->with("message", __("Success"));
        }

        //return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
