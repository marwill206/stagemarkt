<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegister ()
    {
        return view('auth.Register');
    }

    public function showLogin ()
    {
        return view('auth.login');
    }
}
