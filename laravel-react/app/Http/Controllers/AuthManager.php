<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthManager extends Controller
{
    function login(){
        return view('login');
    }

    function register(){
        return view('register');
    }
    function loginPost(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('home'));
        }
        return redirect(route('login'))->with("error", "Je login gegevens zijn niet juist");

    }

    function registerPost(Request $request){
          $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        
        if(!$user){
        return redirect(route('register'))->with("error", "Registreren is niet gelukt probeer het later opnieuw");
        }
        
        return redirect(route('login'))->with("success", "Registreren is gelukt, login om in de app te komen");

    }


    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
        
    }
}
