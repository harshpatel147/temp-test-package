<?php

namespace Smiley\AdminlteStarterPackage\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * send forgot password email 
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->isMethod('POST')){
            $request->validate([
                'email' => ['required', 'string', 'email']
            ]);
            
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                    ? back()->with('alertMsg', __($status))->with('alertClass', 'alert-success')
                    : back()->withErrors(['email' => __($status)]);
        }else{
            return view('auth.passwords.email');
        }
    }

    /**
     * show reset password form 
     * 
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * reset password 
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function resetPasswordPostRequest(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('alertMsg', __($status))->with('alertClass', 'alert-success')
                    : back()->withErrors(['email' => [__($status)]]);
    }

}