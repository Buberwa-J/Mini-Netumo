<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Forgot Your Password?</h2>
        <p class="text-sm text-slate-600 dark:text-slate-400">
            No problem. Enter your email address below, and we'll send you a link to reset your password.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="dark:text-slate-300" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600 focus:border-sky-500 dark:focus:border-sky-500 focus:ring-sky-500 dark:focus:ring-sky-500" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-6">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-sky-500 hover:bg-sky-600 dark:bg-sky-600 dark:hover:bg-sky-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                {{ __('Email Password Reset Link') }}
            </button>

            <div class="mt-4">
                <a class="underline text-sm text-slate-600 hover:text-sky-500 dark:text-slate-400 dark:hover:text-sky-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-800" href="{{ route('login') }}">
                    Back to Login
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
