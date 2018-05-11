<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\UserUploadAvatar;

use Illuminate\Http\Request;
use Carbon\Carbon;

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
                    /*
                    if (env('FILESYSTEM_DRIVER') === 'public') {
                        $path = $request->file('avatar')->store('avatars');
                        $user->avatar = asset($path);
                    }
                    */
                    event(new UserUploadAvatar($user, $request->file('avatar')->getPathname()));
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
