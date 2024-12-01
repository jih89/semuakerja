<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    public function index()
    {
        $jobPosts = JobPost::paginate(10);
        return view('job_posts.index', compact('jobPosts'));
    }

    public function create()
    {
        return view('job_posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'jobType' => 'required|in:full-time,part-time,freelance',
            'contact' => 'required|string|max:255',
            'description' => 'required|string',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|min:0|gte:salary_min',
        ]);

        // Debugging statements
        Log::info('Title: ' . $request->title);
        Log::info('Location: ' . $request->location);
        Log::info('Job Type: ' . $request->jobType);
        Log::info('Contact: ' . $request->contact);
        Log::info('Description: ' . $request->description);
        Log::info('Salary Range Min: ' . $request->salary_min);
        Log::info('Salary Range Max: ' . $request->salary_max);

        $jobPost = new JobPost([
            'title' => $request->title,
            'location' => $request->location,
            'jobType' => $request->jobType,
            'contact' => $request->contact,
            'description' => $request->description,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'user_id' => Auth::id(),
        ]);

        $jobPost->save();

        return redirect()->route('job-posts.index')->with('success', 'Job post created successfully.');
    }

    public function edit(JobPost $jobPost)
    {
        return view('job_posts.edit', compact('jobPost'));
    }

    public function update(Request $request, JobPost $jobPost)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'jobType' => 'required|in:full-time,part-time,freelance',
            'contact' => 'required|string|max:255',
            'description' => 'required|string',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|min:0|gte:salary_min',
        ]);

        $jobPost->update($request->all());

        return redirect()->route('job-posts.index')->with('success', 'Job post updated successfully.');
    }

    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();

        return redirect()->route('job-posts.index')->with('success', 'Job post deleted successfully.');
    }

    public function welcome()
    {
        $jobPosts = JobPost::latest()->take(6)->get();
        return view('welcome', compact('jobPosts'));
    }
}