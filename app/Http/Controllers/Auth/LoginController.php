<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->status_akun !== 'disetujui') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun belum disetujui oleh RT/RW.']);
            }

            return redirect()->route($this->redirectByRole($user->role));
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    protected function redirectByRole($role)
    {
        return match ($role) {
            'admin' => 'dashboard',
            'rt' => 'rt.dashboard',
            'rw' => 'rw.dashboard',
            'warga' => 'warga.dashboard',
            default => '/',
        };
    }
}

