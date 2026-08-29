<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->status_akun !== 'disetujui') {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum disetujui oleh RT/RW.',
            ]);
        }

        return $next($request);
    }
}

