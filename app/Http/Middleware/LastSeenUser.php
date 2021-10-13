<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LastSeenUser
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $request->user()->update(['last_seen' => Carbon::now()]);

        return $next($request);
    }
}
