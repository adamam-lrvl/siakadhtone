@props(['name'])

<i data-lucide="{{ $name }}" {{ $attributes->merge(['class' => 'w-5 h-5']) }}></i>