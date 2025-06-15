<x-app-layout>
    <x-slot name="header_title">Add New Target</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
            {{ __('Add New Target') }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto px-2 sm:px-4 md:px-6">
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl p-6 md:p-8">
            <form method="POST" action="{{ route('targets.store') }}" class="space-y-6">
                @csrf
                <div>
                    <x-input-label for="url" class="flex items-center mb-1">
                        <svg class="w-5 h-5 mr-2 text-sky-500 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.978 11.978 0 0112 16.5c-2.998 0-5.74-1.1-7.843-2.918m15.686-5.834A8.959 8.959 0 003 12c0 .778-.099 1.533.284 2.253m0 0A11.978 11.978 0 0012 16.5c2.998 0 5.74-1.1 7.843-2.918M3.284 9.747A8.996 8.996 0 0112 6c2.67 0 5.043.992 6.95 2.652M3.284 9.747A8.996 8.996 0 0012 18c2.67 0 5.043-.992 6.95-2.652m0-5.7A8.96 8.96 0 0012 6v12" /></svg>
                        Website Address
                    </x-input-label>
                    <x-text-input id="url" name="url" type="text" class="block w-full mt-1" 
                                  placeholder="e.g. www.google.com" value="{{ old('url') }}" 
                                  required autofocus autocomplete="off" />
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">No need to type <code class="bg-slate-100 dark:bg-slate-700 px-1 py-0.5 rounded-sm text-xs">https://</code> &mdash; just enter the domain.</p>
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>
                
                <div>
                    <x-input-label for="name" class="flex items-center mb-1">
                        <svg class="w-5 h-5 mr-2 text-slate-500 dark:text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M1 2.75A.75.75 0 011.75 2h11.5a.75.75 0 010 1.5H1.75A.75.75 0 011 2.75zM1 6.25A.75.75 0 011.75 5.5h11.5a.75.75 0 010 1.5H1.75A.75.75 0 011 6.25zM1.75 9a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5h-7.5z" />
                          </svg>
                          Friendly Name (Optional)
                    </x-input-label>
                    <x-text-input id="name" name="name" type="text" class="block w-full mt-1" 
                                  placeholder="e.g. My Company Website" value="{{ old('name') }}" 
                                  autocomplete="off" />
                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">A custom name for this target to easily identify it.</p>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end pt-2">
                    <a href="{{ route('targets.index') }}" class="text-sm text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white underline transition-colors">
                        Cancel
                    </a>
                    <x-primary-button class="ms-4">
                        {{ __('Add Target') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 