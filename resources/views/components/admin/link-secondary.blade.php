@props(['route'])

<a href="{{ route($route) }}" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 border border-gray-400 text-gray-600 dark:text-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
