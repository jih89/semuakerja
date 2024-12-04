@extends('layouts.app')

@section('content')
<div class="py-1">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <!-- Page Title -->
            <div class="mb-8">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <h2 class="text-3xl font-bold text-gray-900">Manage Job Postings</h2>
                @else
                    <h2 class="text-3xl font-bold text-gray-900">Job Postings</h2>
                    <p class="mt-2 text-lg text-gray-600">Browse and find the perfect job opportunity for you.</p>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('job-posts.index') }}" method="GET" class="mb-8">
                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               placeholder="Search jobs..."
                               value="{{ request('search') }}"
                               class="w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 focus:border-blue-500 focus:ring-blue-500">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filters Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <!-- Job Type Filter -->
                    <div>
                        <label for="job_type" class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                        <select name="job_type" id="job_type" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Job Types</option>
                            <option value="full-time" {{ request('job_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part-time" {{ request('job_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                            <option value="contract" {{ request('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="internship" {{ request('job_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <select name="location" id="location" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Salary Range Filters -->
                    <div>
                        <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-1">Min Salary</label>
                        <input type="number" 
                               id="salary_min"
                               name="salary_min" 
                               placeholder="Min Salary"
                               value="{{ request('salary_min') }}"
                               class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-1">Max Salary</label>
                        <input type="number" 
                               id="salary_max"
                               name="salary_max" 
                               placeholder="Max Salary"
                               value="{{ request('salary_max') }}"
                               class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between">
                    <!-- Create Button (Left Side) -->
                    @if(auth()->check() && auth()->user()->role === 'employer')
                        <a href="{{ route('job-posts.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create New Job Post
                        </a>
                    @else
                        <div></div> <!-- Empty div untuk menjaga layout -->
                    @endif

                    <!-- Filter Buttons (Right Side) -->
                    <div class="flex space-x-4">
                        <a href="{{ route('job-posts.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Clear Filters
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>

            <!-- Job Listings -->
            <div class="grid gap-6">
                @forelse($jobPosts as $jobPost)
                    @if(auth()->check() && auth()->user()->role === 'job_seeker')
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $jobPost->title }}</h3>
                            <p class="text-gray-600">{{ $jobPost->location }} • {{ ucfirst($jobPost->jobType) }}</p>
                            <p class="text-gray-600">Posted by: {{ $jobPost->user->name }}</p>
                            <p class="text-gray-600 mt-2">Salary: ${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }}</p>
                            
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('job-posts.show', $jobPost) }}" 
                                   class="inline-flex items-center px-6 py-2 text-blue-600 hover:text-blue-800 font-medium rounded-md transition-colors duration-200">
                                    View Details & Apply
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @elseif(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'employer'))
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $jobPost->title }}</h3>
                                    <p class="text-gray-600">{{ $jobPost->location }} • {{ ucfirst($jobPost->jobType) }}</p>
                                    <p class="text-gray-600">Posted by: {{ $jobPost->user->name }}</p>
                                    <p class="text-gray-600">Salary: ${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('job-posts.edit', $jobPost) }}" 
                                           class="text-blue-600 hover:text-blue-800">Edit</a>
                                        <form action="{{ route('job-posts.destroy', $jobPost) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" 
                                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-gray-500 text-center py-4">No job posts found matching your criteria.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $jobPosts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
