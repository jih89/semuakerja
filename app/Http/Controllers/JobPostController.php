<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::query()->with('user');

        // Search by title or company name
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by job type
        if ($request->filled('job_type') && $request->job_type != 'all') {
            $query->where('jobType', $request->job_type);
        }

        // Filter by salary range
        if ($request->filled('salary_min')) {
            $minSalary = (int)$request->salary_min;
            $query->where('salary_min', '>=', $minSalary);
        }
        if ($request->filled('salary_max')) {
            $maxSalary = (int)$request->salary_max;
            $query->where('salary_max', '<=', $maxSalary);
        }

        // Filter by location
        if ($request->filled('location') && $request->location != 'all') {
            $query->where('location', $request->location);
        }

        $jobPosts = $query->latest()->paginate(5)->appends($request->query());
        $locations = JobPost::distinct()->pluck('location');
        
        return view('job_posts.index', compact('jobPosts', 'locations'));
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

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job post created successfully.');
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

        if (auth()->user()->role === 'employer') {
            return redirect()->route('employer.dashboard')
                ->with('success', 'Job post updated successfully.');
        }

        return redirect()->route('admin.job-posts.index')
            ->with('success', 'Job post updated successfully.');
    }

    public function destroy(JobPost $jobPost)
    {
        try {
            DB::beginTransaction();
            
            // Hapus semua applications terkait terlebih dahulu
            $jobPost->applications()->delete();
            
            // Kemudian hapus job post
            $jobPost->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Job post deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete job post');
        }
    }

    public function welcome()
    {
        $jobPosts = JobPost::with('user')
            ->latest()
            ->take(3)
            ->get();
        return view('welcome', compact('jobPosts'));
    }

    public function show(JobPost $jobPost)
    {
        $jobPost->load('user');
        return view('job_posts.show', compact('jobPost'));
    }
}