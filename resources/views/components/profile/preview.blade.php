@props(['jobseeker'])

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="text-2xl text-gray-500">{{ substr($jobseeker->user->name, 0, 1) }}</span>
            </div>
        </div>
        
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900">{{ $jobseeker->user->name }}</h3>
            <p class="text-sm text-gray-500">{{ $jobseeker->user->email }}</p>
            
            <div class="mt-2 space-y-1">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">School:</span> {{ $jobseeker->school }}
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Expected Graduation:</span> {{ $jobseeker->expected_to_graduate }}
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-medium">JLPT Level:</span> {{ $jobseeker->jlpt }}
                </p>
            </div>
        </div>
        
        <div class="flex-shrink-0">
            <span class="px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">
                Score: {{ $jobseeker->total_score ?? 'N/A' }}
            </span>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('operator.jobseekers.show', $jobseeker) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            View Full Profile
        </a>
    </div>
</div> 