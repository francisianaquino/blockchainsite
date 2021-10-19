<?php

namespace App\Http\Controllers;
use App\User;
use Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index() {
        return view('authentication.register');
    }

    public function register(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
         
        return redirect('login')->withSuccess('You have signed-in');
    }

    public function showEmailVerificationNotice() {
        return view('auth.verify');
    }

    public function verifyEmail(EmailVerificationRequest $request) {
        $request->fulfill();
    
        return redirect('/');
    }

    public function resendVerificationEmail(Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
    }
}
