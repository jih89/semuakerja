<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Employer
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'employer') {
                if ($request->routeIs('dashboard')) {
                    return redirect()->route('employer.dashboard');
                }
                return $next($request);
            }
        }

        return redirect()->route('welcome')->with('error', 'You do not have access to this page.');
    }
}
