@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-6">Job Applications</h1>
    
    @if($applications->isEmpty())
        <p class="text-gray-600">No applications yet.</p>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CV</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($applications as $application)
                    <tr>
                        <td class="px-6 py-4">{{ $application->jobPost->title }}</td>
                        <td class="px-6 py-4">
                            {{ $application->user->name }}<br>
                            <span class="text-sm text-gray-500">{{ $application->user->email }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('applications.view-cv', $application) }}" 
                               class="text-blue-600 hover:text-blue-900"
                               target="_blank">
                                View CV
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $application->status === 'on process' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($application->status === 'on process')
                            <form action="{{ route('applications.update-status', $application) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="space-x-2">
                                    <button type="submit" name="status" value="accepted" 
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                        Accept
                                    </button>
                                    <button type="submit" name="status" value="rejected"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                        Reject
                                    </button>
                                </div>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 