@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Job Posts</h1>
        @if ($jobPosts->count())
            <ul>
                @foreach ($jobPosts as $jobPost)
                    <li>
                        <a href="{{ route('job-posts.show', $jobPost) }}">{{ $jobPost->title }}</a>
                    </li>
                @endforeach
            </ul>
            {{ $jobPosts->links() }}
        @else
            <p>No job posts available.</p>
        @endif
    </div>
@endsection