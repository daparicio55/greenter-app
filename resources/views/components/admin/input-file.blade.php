@props(['name', 'title'])

<label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="{{ $name }}">
    {{ $title }}
</label>

<input 
    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 rounded-md shadow-sm mt-1 block w-full cursor-pointer 
    file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-white hover:file:bg-gray-700"
    id="{{ $name }}" 
    name="{{ $name }}" 
    type="file"
>

@error($name)
    <p class="text-red-500 text-xs mt-1 animate-bounce">
        {{ $message }}
    </p>
@enderror

