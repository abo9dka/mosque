<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        return view('login'); // تم حذف الـ Slash من البداية
    }

    // معالجة عملية تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|digits:9',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'phone' => $credentials['phone'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'phone' => 'رقم الهاتف أو كلمة المرور غير صحيحة.',
        ])->onlyInput('phone');
    }
    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
