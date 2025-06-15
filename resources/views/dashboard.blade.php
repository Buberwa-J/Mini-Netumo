<x-app-layout>
    <x-slot name="header_title">Dashboard</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
            {{ __('Monitoring Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 space-y-8">

        {{-- Stat Cards Section --}}
        <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            {{-- Total Targets --}}
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl p-5 flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 flex items-center justify-center rounded-lg bg-sky-100 dark:bg-sky-500/20">
                        <svg class="w-8 h-8 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.978 11.978 0 0112 16.5c-2.998 0-5.74-1.1-7.843-2.918m15.686-5.834A8.959 8.959 0 003 12c0 .778.099 1.533.284 2.253m0 0A11.978 11.978 0 0012 16.5c2.998 0 5.74-1.1 7.843-2.918M3.284 9.747A8.996 8.996 0 0112 6c2.67 0 5.043.992 6.95 2.652M3.284 9.747A8.996 8.996 0 0012 18c2.67 0 5.043-.992 6.95-2.652m0-5.7A8.96 8.96 0 0012 6v12" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Targets</p>
                    <p class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ $totalTargets }}</p>
                    <a href="{{ route('targets.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">View All &rarr;</a>
                </div>
            </div>

            {{-- Targets Up --}}
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl p-5 flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 flex items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-500/20">
                        <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25 4.5-4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Targets Up</p>
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $targetsUp }}</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Online</p>
                </div>
            </div>

            {{-- Targets Down/Issue --}}
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl p-5 flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 flex items-center justify-center rounded-lg bg-rose-100 dark:bg-rose-500/20">
                        <svg class="w-7 h-7 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C1.934 16.971 6.029 21 11 21c.656 0 1.301-.072 1.934-.21M15.75 1.575A10.468 10.468 0 0011 1C6.029 1 1.934 4.029 1.934 9c0 .656.072 1.301.21 1.934m13.606-1.675A10.477 10.477 0 0020.066 9c0-4.971-4.029-8-9-8a10.468 10.468 0 00-4.244 1.002M18.07 14.452A10.46 10.46 0 0111 19c-4.971 0-9-4.029-9-9 .275 0 .549.014.821.04M15.937 5.562L4.063 17.438" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Down / Issues</p>
                    <p class="text-3xl font-bold text-rose-600 dark:text-rose-400">{{ $targetsDown }}</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400\">Issues Reported</p>
                </div>
            </div>

            {{-- Targets Pending --}}
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl p-5 flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-500/20">
                        <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pending</p>
                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $targetsPending }}</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Awaiting check</p>
                </div>
            </div>
        </div>

        {{-- Monitored Targets List --}}
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl">
            <div class="px-4 py-5 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center sm:justify-between mb-6">
                    <h3 class="text-xl font-semibold leading-6 text-slate-900 dark:text-slate-100">Monitored Targets Overview</h3>
                    <a href="{{ route('targets.index') }}" class="mt-3 sm:mt-0 text-sm font-medium text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">
                        Manage All Targets &rarr;
                    </a>
                </div>
                @if($allUserTargets->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.564A.562.562 0 019 14.437V9.564z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-semibold text-slate-800 dark:text-slate-200">No targets yet</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Get started by adding a new target to monitor.</p>
                        <div class="mt-6">
                            <a href="{{ route('targets.create') }}" class="inline-flex items-center rounded-md bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 transition-colors">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"> <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z\" /> </svg>
                                Add New Target
                            </a>
                        </div>
                    </div>
                @else
                    <div class="flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                    <thead class="bg-slate-50 dark:bg-slate-800/60">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider sm:pl-3">Target</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="hidden sm:table-cell px-3 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Latency</th>
                                            <th scope="col" class="hidden md:table-cell px-3 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">SSL Health</th>
                                            <th scope="col" class="hidden lg:table-cell px-3 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Last Check</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3\"><span class="sr-only">View</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                        @foreach ($allUserTargets as $target)
                                            @php
                                                $latestStatus = $target->latestStatusLog;
                                                $latestSsl = $target->latestSslCheck;
                                                $hasActiveAlert = $target->alerts->where('resolved_at', null)->isNotEmpty();

                                                $statusText = 'Pending';
                                                $statusColor = 'amber';
                                                $statusCodeText = '';
                                                $latencyText = 'N/A';
                                                $lastCheckedText = $target->created_at->diffForHumans(null, true) . ' ago (created)';

                                                if ($latestStatus) {
                                                    $lastCheckedText = $latestStatus->created_at->diffForHumans();
                                                    $latencyText = $latestStatus->response_time . ' ms';
                                                    if ($latestStatus->status_code >= 200 && $latestStatus->status_code < 400 && !$hasActiveAlert) {
                                                        $statusText = 'Up';
                                                        $statusColor = 'emerald';
                                                    } else {
                                                        $statusText = 'Down'; // Default to Down if not explicitly Up or if alert exists
                                                        $statusColor = 'rose';
                                                    }
                                                    $statusCodeText = ' (' . $latestStatus->status_code . ')';
                                                } else if ($hasActiveAlert) { // If no status log but active alert, it's down
                                                     $statusText = 'Down';
                                                     $statusColor = 'rose';
                                                }


                                                $sslText = 'N/A';
                                                $sslColorClass = 'text-slate-500 dark:text-slate-400';
                                                if ($latestSsl) {
                                                    if ($latestSsl->is_valid && $latestSsl->days_to_expiry !== null) {
                                                        $sslText = $latestSsl->days_to_expiry . ' days';
                                                        if ($latestSsl->days_to_expiry <= 7) $sslColorClass = 'text-rose-600 dark:text-rose-400 font-semibold';
                                                        elseif ($latestSsl->days_to_expiry <= 14) $sslColorClass = 'text-amber-600 dark:text-amber-400 font-semibold';
                                                        else $sslColorClass = 'text-emerald-600 dark:text-emerald-400';
                                                    } elseif (!$latestSsl->is_valid) {
                                                        $sslText = 'Invalid';
                                                        $sslColorClass = 'text-rose-600 dark:text-rose-400 font-semibold';
                                                    }
                                                    // If status never checked, but SSL was, use SSL check time
                                                    if (!$latestStatus && $latestSsl->created_at->gt($target->created_at)) {
                                                        $lastCheckedText = $latestSsl->created_at->diffForHumans();
                                                    }
                                                }
                                            @endphp
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors duration-150">
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-3">
                                                    <div class="flex items-center">
                                                        <div @class([
                                                            'h-2.5 w-2.5 rounded-full me-3 shrink-0',
                                                            'bg-emerald-500' => $statusColor === 'emerald',
                                                            'bg-rose-500' => $statusColor === 'rose',
                                                            'bg-amber-500' => $statusColor === 'pending',
                                                        ])></div>
                                                        <div class="font-medium text-slate-800 dark:text-slate-100 truncate group" title="{{ $target->url }}">
                                                            {{ Str::limit($target->url, 35) }}
                                                            <span class="hidden group-hover:inline text-xs text-slate-500">{{ $target->url }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                    <span @class([
                                                        'inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium',
                                                        'bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300' => $statusColor === 'emerald',
                                                        'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300' => $statusColor === 'rose',
                                                        'bg-amber-100 text-amber-700 dark:bg-amber-700/30 dark:text-amber-300' => $statusColor === 'pending',
                                                    ])>
                                                        {{ $statusText }}{{ $statusCodeText }}
                                                    </span>
                                                </td>
                                                <td class="hidden sm:table-cell whitespace-nowrap px-3 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $latencyText }}</td>
                                                <td class="hidden md:table-cell whitespace-nowrap px-3 py-4 text-sm {{ $sslColorClass }}">{{ $sslText }}</td>
                                                <td class="hidden lg:table-cell whitespace-nowrap px-3 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $lastCheckedText }}</td>
                                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3">
                                                    <a href="{{ route('targets.history', $target) }}" class="text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">Details<span class="sr-only">, {{ $target->url }}</span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if($allUserTargets->count() >= 10) {{-- Show only if there are more targets than shown or equal to limit --}}
                        <div class="mt-6 text-center border-t border-slate-200 dark:border-slate-700 pt-4">
                            <a href="{{ route('targets.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">
                                View all {{ $totalTargets }} targets &rarr;
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Recent Active Alerts Section --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 shadow-xl rounded-xl">
                 <div class="px-4 py-5 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center sm:justify-between mb-6">
                        <h3 class="text-xl font-semibold leading-6 text-slate-900 dark:text-slate-100">Recent Active Alerts</h3>
                         @if($activeAlertsCount > 0)
                        <a href="{{ route('alerts.index') }}" class="mt-3 sm:mt-0 text-sm font-medium text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">
                            View All {{ $activeAlertsCount }} Alerts &rarr;
                        </a>
                        @endif
                    </div>
                    @if($recentActiveAlerts->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-emerald-500 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg>
                            <h3 class="mt-2 text-lg font-semibold text-slate-800 dark:text-slate-200">All Clear!</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">You have no active alerts right now.</p>
                        </div>
                    @else
                        <ul role="list" class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($recentActiveAlerts as $alert)
                            <li class="relative flex items-start space-x-4 py-4 group hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors duration-150 rounded px-2 -mx-2">
                                <div class="flex-shrink-0">
                                    @php
                                        $alertTypeClass = 'bg-slate-400 dark:bg-slate-500';
                                        $alertIconPath = 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z'; // Default info icon

                                        if ($alert->type === 'downtime') {
                                            $alertTypeClass = 'bg-rose-500 dark:bg-rose-600';
                                            $alertIconPath = 'M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457L3 3m5.457 5.457l7.086 7.086m0 0L21 21'; // BoltSlash
                                        } elseif ($alert->type === 'ssl_invalid') {
                                            $alertTypeClass = 'bg-rose-500 dark:bg-rose-600';
                                            $alertIconPath = 'M12 9v3.75m0 9.75a9 9 0 110-18 9 9 0 010 18zm0-9.75h.008v.008H12v-.008z'; // ExclamationCircle (similar)
                                        } elseif ($alert->type === 'ssl_expiry') {
                                            $alertTypeClass = 'bg-amber-500 dark:bg-amber-600';
                                            $alertIconPath = 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'; // Clock
                                        }
                                    @endphp
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full {{ $alertTypeClass }}\">
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $alertIconPath }}" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-auto">
                                    <h3 class="font-medium text-slate-800 dark:text-slate-100">
                                        <a href="{{ route('targets.history', $alert->target_id) }}" class="hover:underline">
                                            {{ $alert->target->name ?: Str::limit($alert->target->url, 30) }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        <span class="font-medium capitalize">{{ str_replace('_', ' ', $alert->type) }}</span> - {{ $alert->message }}
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                        Triggered {{ $alert->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 self-center ms-2">
                                    <a href="{{ route('targets.history', $alert->target_id) }}" class="opacity-0 group-hover:opacity-100 transition-opacity text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @if($activeAlertsCount > $recentActiveAlerts->count())
                            <div class="mt-5 text-center border-t border-slate-200 dark:border-slate-700 pt-4">
                                <a href="{{ route('alerts.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">
                                    View all {{ $activeAlertsCount }} active alerts &rarr;
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Quick Actions / Call to Action --}}
            <div class="lg:col-span-1 bg-white dark:bg-slate-800 shadow-xl rounded-xl p-6">
                <h3 class="text-xl font-semibold leading-6 text-slate-900 dark:text-slate-100 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('targets.create') }}" class="w-full flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:ring-offset-slate-800 transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor"> <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /> </svg>
                        Add New Target
                    </a>
                    <a href="{{ route('profile.edit') }}" class="w-full flex items-center justify-center px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm text-sm font-medium text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:ring-offset-slate-800 transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" /> </svg>
                        Update Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm text-sm font-medium text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:ring-offset-slate-800 transition-colors">
                            <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2B.75.75 0 0010.75 3h-5.5A.75.75 0 004.5 3.75v12.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z" clip-rule="evenodd" /><path fill-rule="evenodd" d="M6 10a.75.75 0 01.75-.75h9.546l-1.048-.943a.75.75 0 111.004-1.114l2.5 2.25a.75.75 0 010 1.114l-2.5 2.25a.75.75 0 11-1.004-1.114l1.048-.943H6.75A.75.75 0 016 10z" clip-rule="evenodd" /></svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
