@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $jobPost->title }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Company:</strong> {{ $jobPost->company }}</p>
                    <p><strong>Location:</strong> {{ $jobPost->location }}</p>
                    <p><strong>Salary:</strong> {{ $jobPost->salary }}</p>
                    <p><strong>Description:</strong> {{ $jobPost->description }}</p>
                    <p><strong>Requirements:</strong> {{ $jobPost->requirements }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('jobPost.apply', $jobPost->id) }}" class="btn btn-primary">Apply for this job</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection1