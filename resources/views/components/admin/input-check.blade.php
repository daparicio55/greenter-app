@props(['name', 'label'])

<div>
    <input 
        type="checkbox" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        class="w-5 h-5 border-gray-300 dark:border-gray-600 rounded-md focus:ring-gray-500 dark:focus:ring-gray-400 text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out cursor-pointer" value="1">
    <label for="{{ $name }}" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
        {{ $label }}
    </label>
</div>

@error($name)
    <p class="text-red-500 text-xs mt-1 animate-bounce">
        {{ $message }}
    </p>
@enderror