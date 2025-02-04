@props(['name', 'title', 'value' => '', 'type' => 'text'])
<label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="name">
    {{ $title }}
</label>
<input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name,$value) }}" autofocus="autofocus" autocomplete="{{ $name }}">
@error($name)
    <p class="text-red-500 text-xs mt-1 animate-bounce">
        {{ $message }}
    </p>
@enderror