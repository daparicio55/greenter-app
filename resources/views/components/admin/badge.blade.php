@props(['color'=>'red'])
<span {{ $attributes->merge(['class'=>"px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-$color-100 text-$color-800 dark:bg-$color-900 dark:text-$color-300"]) }}>
    {{ $slot }}
</span>