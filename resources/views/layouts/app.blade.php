<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mini-Netumo') }} - {{ $header_title ?? 'Application' }}</title>

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

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        <link rel="alternate icon" type="image/x-icon" href="/favicon.ico">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-100 dark:bg-slate-950">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-slate-800/50 shadow-md dark:shadow-slate-700/50">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-8">
                {{ $slot }}
            </main>
        </div>
        @if(getenv('INSTANCE_ID'))
            @php
                $instanceId = getenv('INSTANCE_ID');
                // Extracts numbers from strings like 'app1', 'web2', etc.
                $instanceNum = preg_replace('/[^0-9]/', '', $instanceId);
            @endphp
            <div style="position: fixed; bottom: 8px; right: 8px; background-color: #0F172A; color: #94A3B8; padding: 4px 8px; font-size: 11px; border-radius: 4px; z-index: 9999; opacity: 0.75;">
                Instance: {{ $instanceNum ?: $instanceId }}
            </div>
        @endif
    </body>
</html>
