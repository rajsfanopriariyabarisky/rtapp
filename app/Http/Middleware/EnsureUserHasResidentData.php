<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasResidentData
{
    public function handle($request, Closure $next)
    {
        if (!\App\Models\Resident::where('user_id', auth()->id())->exists()) {
            return redirect()->route('residents.create');
        }

        return $next($request);
    }

}
