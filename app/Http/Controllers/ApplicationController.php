<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'job_seeker') {
            return redirect()->route('welcome')->with('error', 'Unauthorized access');
        }

        $applications = Application::where('user_id', Auth::id())
            ->with(['jobPost.user'])
            ->latest()
            ->get();

        return view('user.applications', compact('applications'));
    }

    public function apply(Request $request, JobPost $jobPost)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to apply for a job.');
        }

        $request->validate([
            'cv' => 'required|file|mimes:pdf,docx|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs');

        Application::create([
            'user_id' => Auth::id(),
            'job_post_id' => $jobPost->id,
            'cv' => $cvPath,
            'status' => 'on process'
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully.');
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $application->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    public function viewCV(Application $application)
    {
        // Periksa apakah employer yang mengakses adalah pemilik job post
        $jobPost = $application->jobPost;
        if ($jobPost->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Periksa apakah file exists
        if (!Storage::exists($application->cv)) {
            abort(404, 'CV file not found.');
        }

        // Return file response
        return Storage::response($application->cv);
    }
}
