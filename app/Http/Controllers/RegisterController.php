<?php

namespace App\Http\Controllers;
use App\User;
use Hash;

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
}
