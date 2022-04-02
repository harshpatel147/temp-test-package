<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Smiley\AdminlteStarterPackage\Http\Controllers\Auth\ForgotPasswordController;
use Smiley\AdminlteStarterPackage\Http\Controllers\Auth\LoginController;
use Smiley\AdminlteStarterPackage\Http\Controllers\Auth\RegisterController;

Route::group(['middleware' => config('adminlte-starter-smiley.middleware', ['web'])], function () {
    $enableAuth = config('adminlte-starter-smiley.enable_default_authentication', true);
    
    if($enableAuth){
        Route::get('/home', function(){
            return view('home');
        })->middleware('auth')->name('home');

        Route::get('/register', [RegisterController::class, 'index'])->name('register');
        Route::post('/register', [RegisterController::class, 'create'])->name('register');

        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // logout 

        Route::get('/email/verify', function () {
            return view('auth.verify-email');
        })->middleware('auth')->name('verification.notice'); // display page for resend the mail for email verification 

        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect('/home')->with('alertMsg', 'Great Job! Email Verification Successfully done')->with('alertClass', 'alert-success');
        })->middleware(['auth', 'signed'])->name('verification.verify'); // verify the email

        Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
            $request->user()->sendEmailVerificationNotification();
        
            return back()->with('alertMsg', 'Verification link sent!')->with('alertClass', 'alert-success');
        })->middleware(['auth', 'throttle:6,1'])->name('verification.send'); // resend verification mail

        Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('password.request'); // forgot password page
        Route::post('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('password.email'); // forgot password e-mail send

        Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('password.reset'); // reset password page
        Route::post('/reset-password', [ForgotPasswordController::class, 'resetPasswordPostRequest'])->middleware('guest')->name('password.update'); // reset password
    } else {
        Route::get('/home', function(){
            return view('starter');
        });
    }
});