<?php

namespace Smiley\AdminlteStarterPackage\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
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
     * show register form
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.register');
    }
    
    /**
     * Get validation rules for validate Register request.
     *
     * @return array
     */
    protected function validationRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Create a new user 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\User
     */
    public function create(Request $request)
    {
        $this->validate($request, $this->validationRules());

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->sendEmailVerificationNotification(); // for send verification mail
        // event(new Registered($user)); // for send verification mail ... use Illuminate\Auth\Events\Registered
        return redirect('/login')->with('alertMsg', 'Please check Mail and verify before login')->with('alertClass', 'alert-success');
    }
}
