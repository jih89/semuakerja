@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Job Post</h1>
    <form action="{{ route('jobPost.update', $jobPost->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $jobPost->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ $jobPost->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $jobPost->location }}" required>
        </div>

        <div class="form-group">
            <label for="salary">Salary</label>
            <input type="number" class="form-control" id="salary" name="salary" value="{{ $jobPost->salary }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Job Post</button>
    </form>
</div>
@endsection