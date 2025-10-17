<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->user_type === "student") {
                // dd('Student');
                return redirect()->route('students.dashboard');
            } elseif ($user->user_type === 'admin') {
                return redirect()->intended('dashboard');
            } elseif ($user->user_type === 'teacher') {
                // dd('Teacher');
                return redirect()->route('teacher.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return to_route('login');
    }
}
