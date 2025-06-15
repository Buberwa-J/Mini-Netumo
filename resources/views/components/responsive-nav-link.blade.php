@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-sky-500 dark:border-sky-400 text-start text-base font-semibold text-sky-700 dark:text-sky-300 bg-sky-100 dark:bg-sky-800/50 focus:outline-none focus:text-sky-800 dark:focus:text-sky-200 focus:bg-sky-200 dark:focus:bg-sky-700 focus:border-sky-600 dark:focus:border-sky-500 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-600 dark:text-slate-300 hover:text-sky-700 dark:hover:text-sky-300 hover:bg-slate-200 dark:hover:bg-slate-700/50 hover:border-slate-300 dark:hover:border-slate-600 focus:outline-none focus:text-sky-700 dark:focus:text-sky-300 focus:bg-slate-200 dark:focus:bg-slate-700/50 focus:border-slate-300 dark:focus:border-slate-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
