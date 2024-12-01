<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Employer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            Log::info('User role: ' . Auth::user()->role); // Log the user's role for debugging
            if (Auth::user()->role === 'employer') {
                return $next($request);
            }
        }

        return redirect()->route('home')->with('error', 'You do not have access to this page.');
    }
}
