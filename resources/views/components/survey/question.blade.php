@props(['question', 'name' => 'responses[]'])

<div class="bg-white rounded-lg shadow-md p-6 mb-4">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $question->text }}</h3>
    
    <div class="space-y-2">
        @foreach($question->options as $option)
            <div class="flex items-center">
                <input type="radio" 
                       name="{{ $name }}[{{ $question->id }}]" 
                       value="{{ $option }}" 
                       id="option_{{ $question->id }}_{{ $loop->index }}"
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                <label for="option_{{ $question->id }}_{{ $loop->index }}" 
                       class="ml-3 block text-sm font-medium text-gray-700">
                    {{ $option }}
                </label>
            </div>
        @endforeach
    </div>
</div> 