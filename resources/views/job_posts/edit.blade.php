@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Job Post</h1>
        <p class="text-gray-600 mt-2">Update your job posting details below.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ auth()->user()->role === 'admin' ? route('admin.job-posts.update', $jobPost) : route('job-posts.update', $jobPost) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                    <input type="text" name="title" id="title" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('title', $jobPost->title) }}" 
                        required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('location', $jobPost->location) }}"
                        required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Type -->
                <div>
                    <label for="jobType" class="block text-sm font-medium text-gray-700">Job Type</label>
                    <select name="jobType" id="jobType" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="full-time" {{ old('jobType', $jobPost->jobType) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ old('jobType', $jobPost->jobType) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="freelance" {{ old('jobType', $jobPost->jobType) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                    @error('jobType')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact -->
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contact Information</label>
                    <input type="text" name="contact" id="contact" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('contact', $jobPost->contact) }}"
                        required>
                    @error('contact')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary Range -->
                <div>
                    <label for="salary_min" class="block text-sm font-medium text-gray-700">Minimum Salary</label>
                    <input type="number" name="salary_min" id="salary_min" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('salary_min', $jobPost->salary_min) }}"
                        required>
                    @error('salary_min')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="salary_max" class="block text-sm font-medium text-gray-700">Maximum Salary</label>
                    <input type="number" name="salary_max" id="salary_max" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('salary_max', $jobPost->salary_max) }}"
                        required>
                    @error('salary_max')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Job Description</label>
                    <textarea name="description" id="description" rows="6" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>{{ old('description', $jobPost->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.job-posts.index') : route('employer.dashboard') }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Job Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection