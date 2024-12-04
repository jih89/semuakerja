<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'employer') {
                return redirect()->route('employer.dashboard');
            } elseif (Auth::user()->role === 'job_seeker') {
                return redirect()->route('welcome');
            }
        }
        return redirect()->route('welcome');
    }
}
