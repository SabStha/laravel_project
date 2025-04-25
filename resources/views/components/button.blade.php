@props(['type' => 'submit', 'variant' => 'primary'])

@php
$classes = [
    'primary' => 'bg-blue-500 hover:bg-blue-600 text-white',
    'secondary' => 'bg-gray-500 hover:bg-gray-600 text-white',
    'success' => 'bg-green-500 hover:bg-green-600 text-white',
    'danger' => 'bg-red-500 hover:bg-red-600 text-white',
];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "px-4 py-2 rounded-md font-medium {$classes[$variant]}"]) }}>
    {{ $slot }}
</button> 