<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class MustVerifyEmail
{
    public function handle($request, $next)
    {
        if (Auth::user()->email_verified_at == null) {
            return redirect('/email/verify');
        }

        return $next($request);
    }
}
