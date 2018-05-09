<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\VerifyUser;
use App\Mail\VerifyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'new_email' => 'required|string|email|max:255|unique:users,email',
            'new_password' => 'required|string|min:6',
            'terms_and_conditions' => 'accepted',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['new_email'],
            'name' => $data['new_email'],
            'password' => bcrypt($data['new_password']),
        ]);

        $user->verifyUser()->create([
            "token" => str_random(40)
        ]);
        Mail::to($user->email)->send(new VerifyMail($user));
        
    }
    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return view('auth.verifySent');
    }
    public function verify() 
    {
        return view('auth.verifySent');
    }
    public function verifyEmail(string $token)
    {
        $verifier = VerifyUser::where('token', $token)->with('user')->first();
        if ($verifier) {
            $user = $verifier->user;
            if (!$user->verified) {
                $user->update(['verified' => true]);
            
                // delete the token record
                $verified->delete();
                // manually log this user in
                auth()->loginUsingId($user->id);
                // redirect the user
                return redirect("/home");
            }
        }
        else {
            return redirect("/tokennotfound");
        }
    }
}
