<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mini-Netumo') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Figtree', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-100 via-slate-50 to-sky-100 dark:from-slate-800 dark:via-slate-900 dark:to-sky-900">
            <div class="mb-8">
                <a href="/" class="flex items-center space-x-2 text-slate-800 dark:text-slate-200 hover:text-sky-600 dark:hover:text-sky-400 transition-colors duration-300">
                    <!-- Heroicon - GlobeAlt -->
                    <svg class="h-12 w-12 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.978 11.978 0 0112 16.5c-2.998 0-5.74-1.1-7.843-2.918m15.686-5.834A8.959 8.959 0 003 12c0 .778.099 1.533.284 2.253m0 0A11.978 11.978 0 0012 16.5c2.998 0 5.74-1.1 7.843-2.918M3.284 9.747A8.996 8.996 0 0112 6c2.67 0 5.043.992 6.95 2.652M3.284 9.747A8.996 8.996 0 0012 18c2.67 0 5.043-.992 6.95-2.652m0-5.7A8.96 8.96 0 0012 6v12" />
                    </svg>
                    <span class="text-4xl font-bold tracking-tight">Mini-Netumo</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-0 px-8 py-8 bg-white dark:bg-slate-800 shadow-xl dark:shadow-2xl overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>
            <footer class="mt-12 text-center text-sm text-slate-600 dark:text-slate-400">
                &copy; {{ date('Y') }} Mini-Netumo. All rights reserved. Uptime monitoring made easy.
            </footer>
        </div>
    </body>
</html>
