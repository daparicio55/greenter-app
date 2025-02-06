@props(['route'])
<div class="inline-block">
    <a href="{{ $route }}" {{ $attributes->merge(['class'=>'px-3 py-1 text-sm font-medium text-white bg-gray-700 rounded-md hover:bg-gray-800 focus:ring-2 focus:ring-gray-500']) }}>
        {{ $slot }}
    </a>
</div>
