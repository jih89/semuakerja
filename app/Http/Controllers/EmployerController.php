<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\User;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function dashboard()
    {
        // Ambil job posts milik employer yang sedang login
        $jobPosts = JobPost::where('user_id', Auth::id())->latest()->get();
        
        return view('employer.dashboard', compact('jobPosts'));
    }

    public function applications()
    {
        // Perbaikan query untuk mengambil applications
        $applications = Application::whereHas('jobPost', function($query) {
            $query->where('user_id', Auth::id());
        })->with(['jobPost', 'user'])->get();

        return view('employer.applications', compact('applications'));
    }
} 