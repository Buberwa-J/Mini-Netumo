@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-sky-500 dark:border-sky-400 text-sm font-semibold leading-5 text-slate-900 dark:text-sky-400 focus:outline-none focus:border-sky-600 dark:focus:border-sky-500 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 hover:border-slate-300 dark:hover:border-slate-700 focus:outline-none focus:text-sky-600 dark:focus:text-sky-400 focus:border-slate-300 dark:focus:border-slate-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
