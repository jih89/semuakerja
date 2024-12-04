@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h2 class="text-2xl font-bold mb-4">My Applications</h2>

    @if($applications->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500">You haven't applied to any jobs yet.</p>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($applications as $application)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('job-posts.show', $application->jobPost) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $application->jobPost->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $application->jobPost->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $application->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($application->status === 'accepted')
                                        bg-green-100 text-green-800
                                    @elseif($application->status === 'rejected')
                                        bg-red-100 text-red-800
                                    @else
                                        bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection