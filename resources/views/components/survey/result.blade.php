@props(['response'])

<div class="bg-white rounded-lg shadow-md p-6 mb-4">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">{{ $response->question->text }}</h3>
            <p class="text-sm text-gray-500 mt-1">Your answer: {{ $response->response }}</p>
        </div>
        <span class="px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">
            Score: {{ $response->score }}
        </span>
    </div>
    
    @if($response->feedback)
        <div class="mt-4 p-4 bg-gray-50 rounded-md">
            <p class="text-sm text-gray-600">{{ $response->feedback }}</p>
        </div>
    @endif
</div> 