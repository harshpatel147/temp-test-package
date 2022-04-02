<?php

namespace Smiley\AdminlteStarterPackage\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smiley\AdminlteStarterPackage\SmileyAuth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * show login form
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Get validation rules for validate Login request.
     *
     * @return array
     */
    protected function validationRules()
    {
        return [
            SmileyAuth::username() => ['required', 'string'],
            'password' => ['required'],
        ];
    }

    /**
     * authenticate the user credential is valid or not 
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, $this->validationRules());

        $credentials = $request->only(SmileyAuth::username(), 'password');

        if(!Auth::attempt($credentials)){
            return redirect('login')->withErrors([SmileyAuth::username() => ['Oops!!! Invalid username or password. Please try again']]);
        }

        if (Auth::check()) {
            return redirect()->intended();
        }
    }

    /**
     * logout the user & destroy session 
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}