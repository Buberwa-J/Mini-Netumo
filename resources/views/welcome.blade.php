<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Mini-Netumo</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" type="image/x-icon" href="/favicon.ico">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .hero-bg {
            background-color: #0F172A;
            /* slate-900 */
            background-image: linear-gradient(to bottom right, #0F172A, #1E293B, #334155);
            /* slate-900 to slate-700 */
        }

        .dark .hero-bg {
            background-color: #020617;
            /* slate-950 */
            background-image: linear-gradient(to bottom right, #020617, #0F172A, #1E293B);
            /* slate-950 to slate-800 */
        }

        .feature-icon {
            color: #38BDF8;
            /* sky-400 */
        }
    </style>
</head>

<body class="h-full font-sans antialiased leading-normal bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100">
    <div class="min-h-full flex flex-col">
        <!-- Header -->
        <header class="py-6 px-4 sm:px-6 lg:px-8 sticky top-0 z-50 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md shadow-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="/" class="flex items-center space-x-2 transition-colors duration-300">
                    <svg class="h-10 w-10 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.978 11.978 0 0112 16.5c-2.998 0-5.74-1.1-7.843-2.918m15.686-5.834A8.959 8.959 0 003 12c0 .778.099 1.533.284 2.253m0 0A11.978 11.978 0 0012 16.5c2.998 0 5.74-1.1 7.843-2.918M3.284 9.747A8.996 8.996 0 0112 6c2.67 0 5.043.992 6.95 2.652M3.284 9.747A8.996 8.996 0 0012 18c2.67 0 5.043-.992 6.95-2.652m0-5.7A8.96 8.96 0 0012 6v12" />
                    </svg>
                    <span class="text-3xl font-bold tracking-tight text-slate-800 dark:text-slate-200">Mini-Netumo</span>
                </a>
                <nav class="flex flex-col items-center space-y-4 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors rounded-md">Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-sky-500 hover:bg-sky-600 dark:bg-sky-600 dark:hover:bg-sky-700 rounded-md transition-colors">Register</a>
                    @endif
                    @endauth
                    @endif
                </nav>

            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex-grow">
            <div class="hero-bg text-white">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 text-center">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight">
                        <span class="block">Reliable Uptime & SSL</span>
                        <span class="block text-sky-400">Monitoring Made Simple.</span>
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl text-slate-300">
                        Mini-Netumo keeps a vigilant eye on your websites and SSL certificates, so you don't have to. Get notified instantly when issues arise.
                    </p>
                    <div class="mt-10 flex justify-center space-x-4">
                        <a href="{{ route('register') }}" class="inline-block bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 px-8 rounded-lg text-lg transition-transform transform hover:scale-105 shadow-lg">
                            Get Started for Free
                        </a>
                        @if(!Auth::check())
                        <a href="{{ route('login') }}" class="inline-block bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-8 rounded-lg text-lg transition-transform transform hover:scale-105 shadow-lg">
                            Sign In
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-16 sm:py-24 bg-white dark:bg-slate-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-base font-semibold text-sky-600 dark:text-sky-400 tracking-wide uppercase">Features</h2>
                        <p class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-slate-100 sm:text-4xl">Everything you need to stay online.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-12">
                        <div class="text-center p-6 bg-slate-100 dark:bg-slate-700 rounded-xl shadow-lg">
                            <svg class="mx-auto h-12 w-12 feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.375 1.438H5.25A2.25 2.25 0 013 17.25V8.25A2.25 2.25 0 015.25 6H10" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 6.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM15 18.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 8.25v8.25M12 8.25H9.75M12 16.5H9.75M13.5 6H12v2.25H10M13.5 12H12v2.25H10M13.5 18H12v2.25H10M18 10.5h.008v.008H18V10.5zm0 6h.008v.008H18v-0.008zm0-12h.008v.008H18V4.5zm0 6h.008v.008H18v-0.008zM9.75 4.5h.008v.008H9.75V4.5zm0 6h.008v.008H9.75v-0.008zm0 6h.008v.008H9.75v-0.008zM6.75 4.5h.008v.008H6.75V4.5zm0 6h.008v.008H6.75v-0.008zm0 6h.008v.008H6.75v-0.008z" />
                            </svg>
                            <h3 class="mt-5 text-xl font-semibold text-slate-900 dark:text-slate-100">Uptime Monitoring</h3>
                            <p class="mt-2 text-base text-slate-600 dark:text-slate-300">Continuous checks on your website's availability. Get alerted the moment it goes down.</p>
                        </div>
                        <div class="text-center p-6 bg-slate-100 dark:bg-slate-700 rounded-xl shadow-lg">
                            <svg class="mx-auto h-12 w-12 feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <h3 class="mt-5 text-xl font-semibold text-slate-900 dark:text-slate-100">SSL Certificate Checks</h3>
                            <p class="mt-2 text-base text-slate-600 dark:text-slate-300">Automatic monitoring of SSL certificate validity and expiry. Avoid security warnings.</p>
                        </div>
                        <div class="text-center p-6 bg-slate-100 dark:bg-slate-700 rounded-xl shadow-lg">
                            <svg class="mx-auto h-12 w-12 feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <h3 class="mt-5 text-xl font-semibold text-slate-900 dark:text-slate-100">Instant Email Alerts</h3>
                            <p class="mt-2 text-base text-slate-600 dark:text-slate-300">Receive immediate notifications via email when issues are detected or resolved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-8 bg-slate-200 dark:bg-slate-800 border-t border-slate-300 dark:border-slate-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-600 dark:text-slate-400 text-sm">
                <p>&copy; {{ date('Y') }} Mini-Netumo. All rights reserved.</p>
                <p class="mt-1">Keep your digital presence online, effortlessly.</p>
            </div>
        </footer>
    </div>
</body>

</html>