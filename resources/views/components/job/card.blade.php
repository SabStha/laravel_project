@props(['job'])

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">{{ $job->title }}</h3>
            <p class="text-sm text-gray-500">{{ $job->company->name }}</p>
        </div>
        <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">
            {{ number_format($job->salary) }}円
        </span>
    </div>
    
    <div class="mt-4">
        <p class="text-gray-600">{{ Str::limit($job->description, 150) }}</p>
    </div>
    
    <div class="mt-4 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-500">{{ $job->location }}</span>
        </div>
        <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            View Details
        </a>
    </div>
</div> 