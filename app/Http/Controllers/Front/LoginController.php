<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
        public function showLogin()
    {
        return view('front.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withInput()->with('error', 'بيانات الدخول غير صحيحة');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'student') {
            return redirect()->route('front.student.dashboard');
        }

        if ($user->role === 'company') {
            return redirect()->route('cms.company.dashboard');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'supervisor') {
            return redirect()->route('cms.supervisor.dashboard');
        }

        Auth::logout();
        return redirect()->route('front.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('front.auth.login');
    }
}
