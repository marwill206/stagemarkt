<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthManager extends Controller
{
    // 🟦 Show login page
    public function login()
    {
        return view('auth.login'); // make sure your Blade is in resources/views/auth/login.blade.php
    }

    // 🟦 Show registration page
    public function register()
    {
        return view('auth.register'); // make sure your Blade is in resources/views/auth/register.blade.php
    }

    // 🟩 Handle registration
    public function registerPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:student,company',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if (!$user) {
            return redirect(route('register'))->with("error", "Registreren is niet gelukt, probeer het later opnieuw");
        }

        // Create role-specific record
        if ($user->role === 'student') {
            Student::create([
                'User_ID' => $user->id,
                'Student_Name' => $user->name,
                'Student_Email' => $user->email,
                'Profession_ID' => null,
            ]);
        } elseif ($user->role === 'company') {
            Company::create([
                'User_ID' => $user->id,
                'Company_Name' => $user->name,
                'Company_Email' => $user->email,
                'Profession_ID' => null,
            ]);
        }

        // Auto-login after registration (optional)
        return redirect(route('login'))->with('success', 'Registreren is gelukt, login om in de app te komen');


        // Redirect to dashboard based on role
        if ($user->role === 'company') {
            return redirect()->route('company.dashboard')->with('success', 'Welkom, Company!');
        } else {
            return redirect()->route('student.dashboard')->with('success', 'Welkom, Student!');
        }
    }

    // 🟩 Handle login
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'company') {
                return redirect()->route('company.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        return redirect(route('login'))->with("error", "Je login gegevens zijn niet juist");
    }

    // 🟩 Handle logout
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect(route('login'))->with('success', 'Je bent uitgelogd!');
    }
}
