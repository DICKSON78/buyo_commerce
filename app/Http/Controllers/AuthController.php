<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // Login logic here
        return view('auth.login');
    }

    public function choose(){
        return view('auth.choose');
    }

    public function register(Request $request)
    {
        // Registration logic here
        return view('auth.register');
    }
}
