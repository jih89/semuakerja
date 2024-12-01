<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function apply(Request $request, JobPost $jobPost)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to apply for a job.');
        }

        // Validate the request
        $request->validate([
            'cv' => 'required|file|mimes:pdf,docx|max:2048', // Added max file size validation
        ]);

        // Store the CV file
        $cvPath = $request->file('cv')->store('cvs');

        // Create the application
        Application::create([
            'user_id' => Auth::id(),
            'job_post_id' => $jobPost->id,
            'cv' => $cvPath,
            'status' => 'pending',
        ]);

        // Redirect with success message
        return redirect()->route('job-posts.index')->with('success', 'Application submitted successfully.');
    }
}
