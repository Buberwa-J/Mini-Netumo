<x-app-layout>
    <x-slot name="header_title">Alert Log</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
            {{ __('Alert Log') }}
        </h2>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100">All Alerts</h3>
                    </div>
                    @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 rounded-lg border border-emerald-200 dark:border-emerald-700/50">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if($alerts->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-emerald-500 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h4 class="mt-2 text-lg font-semibold text-slate-800 dark:text-slate-200">All Clear!</h4>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">You have no alerts recorded. Keep up the great monitoring!</p>
                    </div>
                    @else
                    <div class="overflow-x-auto border border-slate-200 dark:border-slate-700 sm:rounded-lg shadow-sm hidden md:block">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Target</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Alert Type</th>
                                    <th scope="col" class="hidden md:table-cell px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Message</th>
                                    <th scope="col" class="hidden sm:table-cell px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Triggered At</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Status / Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                @foreach ($alerts as $alert)
                                @php
                                $alertTypeClass = 'bg-slate-100 text-slate-700 dark:bg-slate-700/30 dark:text-slate-300';
                                $alertIconPath = 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z'; // Default info icon (ExclamationCircle)

                                if ($alert->type === 'downtime') {
                                $alertTypeClass = 'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300';
                                $alertIconPath = 'M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457L3 3m5.457 5.457l7.086 7.086m0 0L21 21'; // BoltSlash
                                } elseif ($alert->type === 'ssl_invalid') {
                                $alertTypeClass = 'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300';
                                // Consider a different icon for invalid SSL vs general error if available, or keep ExclamationCircle
                                $alertIconPath = 'M12 9v3.75m0 9.75a9 9 0 110-18 9 9 0 010 18zm0-9.75h.008v.008H12v-.008z'; // ExclamationCircle (same as default, but explicitly for SSL invalid)
                                } elseif ($alert->type === 'ssl_expiry') {
                                $alertTypeClass = 'bg-amber-100 text-amber-700 dark:bg-amber-700/30 dark:text-amber-300';
                                $alertIconPath = 'M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'; // Clock
                                }
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors duration-150">
                                    <td class="px-4 py-4 whitespace-nowrap font-medium text-slate-800 dark:text-slate-100">
                                        @if($alert->target)
                                        <a href="{{ route('targets.history', $alert->target_id) }}" class="text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors duration-150" title="{{ $alert->target->url }}">
                                            {{ Str::limit($alert->target->name ?: $alert->target->url, 35) }}
                                        </a>
                                        @else
                                        <span class="text-slate-400 dark:text-slate-500 italic">Target Deleted</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full {{ $alertTypeClass }}">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $alertIconPath }}" />
                                            </svg>
                                            {{ ucwords(str_replace('_', ' ', $alert->type)) }}
                                        </span>
                                    </td>
                                    <td class="hidden md:table-cell px-4 py-4 text-slate-600 dark:text-slate-400">
                                        <span class="truncate block max-w-md" title="{{ $alert->message }}">{{ Str::limit($alert->message, 60) }}</span>
                                    </td>
                                    <td class="hidden sm:table-cell px-4 py-4 whitespace-nowrap text-slate-600 dark:text-slate-400">
                                        <span title="{{ $alert->created_at->format('Y-m-d H:i A') }}">{{ $alert->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-left">
                                        @if ($alert->resolved_at)
                                        <div class="flex flex-col items-start">
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                                Resolved
                                            </span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400 mt-1" title="{{ $alert->resolved_at->format('Y-m-d H:i A') }}">{{ $alert->resolved_at->diffForHumans() }}</span>
                                        </div>
                                        @else
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300">
                                                <svg class="w-3.5 h-3.5 mr-1.5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zm9-.75a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Active
                                            </span>
                                            <form method="POST" action="{{ route('alerts.resolve', $alert->id) }}" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full inline-flex items-center justify-center text-xs font-semibold px-3 py-1.5 rounded-md text-sky-700 dark:text-sky-300 bg-sky-100 dark:bg-sky-700/30 hover:bg-sky-200 dark:hover:bg-sky-700/50 border border-sky-300 dark:border-sky-600 hover:border-sky-400 dark:hover:border-sky-500 transition-colors" onclick="return confirm('Are you sure you want to mark this alert as resolved?')">
                                                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                                    </svg>
                                                    Mark Resolved
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($alerts->hasPages())
                    <div class="mt-6 px-2">
                        {{ $alerts->links() }}
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Responsive Cards for Mobile --}}
    @if(!$alerts->isEmpty())
    <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 md:hidden space-y-4 mt-4">
        <h4 class="text-md font-semibold text-slate-700 dark:text-slate-300 px-1">Alerts (Recent)</h4>
        @foreach ($alerts as $alert)
        @php
        $alertTypeClass = 'bg-slate-100 text-slate-700 dark:bg-slate-700/30 dark:text-slate-300';
        $alertIconPath = 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z';

        if ($alert->type === 'downtime') {
        $alertTypeClass = 'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300';
        $alertIconPath = 'M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457L3 3m5.457 5.457l7.086 7.086m0 0L21 21';
        } elseif ($alert->type === 'ssl_invalid') {
        $alertTypeClass = 'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300';
        $alertIconPath = 'M12 9v3.75m0 9.75a9 9 0 110-18 9 9 0 010 18zm0-9.75h.008v.008H12v-.008z';
        } elseif ($alert->type === 'ssl_expiry') {
        $alertTypeClass = 'bg-amber-100 text-amber-700 dark:bg-amber-700/30 dark:text-amber-300';
        $alertIconPath = 'M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
        }
        @endphp
        <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-4">
            <div class="flex justify-between items-start mb-2">
                <div class="font-semibold text-slate-800 dark:text-slate-100 text-base break-all">
                    @if($alert->target)
                    <a href="{{ route('targets.history', $alert->target_id) }}" class="text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors duration-150" title="{{ $alert->target->url }}">
                        {{ Str::limit($alert->target->name ?: $alert->target->url, 30) }}
                    </a>
                    @else
                    <span class="text-slate-400 dark:text-slate-500 italic">Target Deleted</span>
                    @endif
                </div>
                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full shrink-0 ms-2 {{ $alertTypeClass }}">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $alertIconPath }}" />
                    </svg>
                    {{ ucwords(str_replace('_', ' ', $alert->type)) }}
                </span>
            </div>

            <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">
                <span class="font-medium text-slate-500 dark:text-slate-400">Message:</span> {{ Str::limit($alert->message, 100) }}
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                <span class="font-medium">Triggered:</span> <span title="{{ $alert->created_at->format('Y-m-d H:i A') }}">{{ $alert->created_at->diffForHumans() }}</span>
            </p>

            <div class="pt-2 border-t border-slate-200 dark:border-slate-700">
                @if ($alert->resolved_at)
                <div class="flex items-center">
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        Resolved
                    </span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 ml-2" title="{{ $alert->resolved_at->format('Y-m-d H:i A') }}">{{ $alert->resolved_at->diffForHumans() }}</span>
                </div>
                @else
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300">
                        <svg class="w-4 h-4 mr-1.5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zm9-.75a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Active
                    </span>
                    <form method="POST" action="{{ route('alerts.resolve', $alert->id) }}" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full inline-flex items-center justify-center text-xs font-semibold px-3 py-1.5 rounded-md text-sky-700 dark:text-sky-300 bg-sky-100 dark:bg-sky-700/30 hover:bg-sky-200 dark:hover:bg-sky-700/50 border border-sky-300 dark:border-sky-600 hover:border-sky-400 dark:hover:border-sky-500 transition-colors" onclick="return confirm('Are you sure you want to mark this alert as resolved?')">
                            <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                            </svg>
                            Mark Resolved
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endforeach
        @if ($alerts->hasPages())
        <div class="mt-4 px-1">
            {{ $alerts->links() }}
        </div>
        @endif
    </div>
    @endif
</x-app-layout>