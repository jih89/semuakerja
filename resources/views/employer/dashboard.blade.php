@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Employer Dashboard</h1>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Job Posts</h2>
                <a href="{{ route('job-posts.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Create New Job Post
                </a>
            </div>

            @if($jobPosts->isEmpty())
                <p class="text-gray-600">You haven't created any job posts yet.</p>
            @else
                <div class="grid gap-6 mb-8">
                    @foreach($jobPosts as $post)
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $post->title }}</h3>
                                    <p class="text-gray-600">{{ $post->location }} • {{ ucfirst($post->jobType) }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('employer.dashboard') }}" 
                                       class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('job-posts.destroy', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" 
                                                onclick="return confirm('Are you sure you want to delete this post?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-gray-600">Salary: ${{ number_format($post->salary_min) }} - ${{ number_format($post->salary_max) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 