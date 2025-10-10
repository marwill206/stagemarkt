<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 🟦 Show registration form
    public function showRegister()
    {
        return view('auth.register'); // lowercase 'register' to match your Blade filename
    }

    // 🟩 Handle registration form submission
    public function registerPost(Request $request)
    {
        

        // Validate form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:student,company',
        ]);

        // Create user record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create role-specific record
        if ($user->role === 'student') {
            Student::create([
                'User_ID' => $user->id,
                'Student_Name' => $user->name,
                'Student_Email' => $user->email,
            ]);
        } elseif ($user->role === 'company') {
            Company::create([
                'User_ID' => $user->id,
                'Company_Name' => $user->name,
                'Company_Email' => $user->email,
            ]);
        }

        // Log in the user automatically
        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'company') {
            return redirect()->route('company.dashboard')->with('success', 'Welcome, Company!');
        } else {
            return redirect()->route('student.dashboard')->with('success', 'Welcome, Student!');
        }
    }

    // 🟨 Show login form
    public function showLogin()
    {
        return view('auth.login');
    }
}
