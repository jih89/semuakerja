@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b bg-gray-50">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $jobPost->title }}</h1>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $jobPost->location }}
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($jobPost->jobType) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Salary Range -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Salary Range</h2>
                <p class="text-gray-600">${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }} per year</p>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Job Description</h2>
                <div class="prose max-w-none text-gray-600">
                    {!! nl2br(e($jobPost->description)) !!}
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Contact Information</h2>
                <p class="text-gray-600">{{ $jobPost->contact }}</p>
            </div>

            <!-- Posted By -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Posted By</h2>
                <p class="text-gray-600">{{ $jobPost->user->name }}</p>
            </div>

            <!-- Apply Button -->
            <div class="mt-8 border-t pt-6">
                @auth
                    @if(auth()->user()->role === 'job_seeker')
                        @php
                            $hasApplied = $jobPost->applications()->where('user_id', auth()->id())->exists();
                        @endphp
                        
                        @if(!$hasApplied)
                            <div class="mt-8 bg-white p-6 rounded-lg shadow-md border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Apply for this Position</h3>
                                
                                <form action="{{ route('job-posts.apply', $jobPost) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Upload your CV here (PDF/DOCX)
                                        </label>
                                        
                                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors duration-200">
                                            <div class="space-y-2 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="cv" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                        <span>Upload a file</span>
                                                        <input id="cv" name="cv" type="file" class="sr-only" accept=".pdf,.docx" required>
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                
                                                <p class="text-xs text-gray-500">
                                                    PDF or DOCX up to 2MB
                                                </p>
                                            </div>
                                        </div>
                                        
                                        @error('cv')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        
                                        <div id="file-selected" class="mt-3 text-sm text-gray-500 hidden">
                                            Selected file: <span id="file-name"></span>
                                        </div>
                                    </div>

                                    <button type="submit" 
                                        class="w-full bg-blue-600 text-white px-6 py-3 rounded-md font-semibold 
                                        hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
                                        transition-colors duration-200">
                                        Submit Application
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="mt-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <p class="text-center text-gray-600">
                            Please <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">login</a> 
                            to apply for this position
                        </p>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
            ← Back to Jobs
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('cv').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            document.getElementById('file-selected').classList.remove('hidden');
            document.getElementById('file-name').textContent = fileName;
        }
    });
</script>
@endpush