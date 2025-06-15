<x-app-layout>
    <x-slot name="header_title">History: {{ Str::limit($target->name ?: $target->url, 30) }}</x-slot>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <h2 class="font-semibold text-2xl text-slate-800 dark:text-slate-100 leading-tight mb-2 md:mb-0">
                {{ __('Monitoring History') }}
            </h2>
            <div class="text-sm text-slate-600 dark:text-slate-300 truncate">
                <a href="{{ $target->url }}" target="_blank" rel="noopener noreferrer" class="hover:text-sky-500 dark:hover:text-sky-400 transition-colors duration-150 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.978 11.978 0 0112 16.5c-2.998 0-5.74-1.1-7.843-2.918m15.686-5.834A8.959 8.959 0 003 12c0 .778-.099 1.533.284 2.253m0 0A11.978 11.978 0 0012 16.5c2.998 0 5.74-1.1 7.843-2.918M3.284 9.747A8.996 8.996 0 0112 6c2.67 0 5.043.992 6.95 2.652M3.284 9.747A8.996 8.996 0 0012 18c2.67 0 5.043-.992 6.95-2.652m0-5.7A8.96 8.96 0 0012 6v12" /></svg>
                    {{ $target->name ?: $target->url }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8">
        <div class="my-6 flex justify-between items-center">
            <a href="{{ route('targets.index') }}" class="inline-flex items-center text-sm font-medium text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors duration-150">
                <svg class="w-5 h-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                {{ __('Back to All Targets') }}
            </a>
            <a href="{{ route('targets.edit', $target) }}" class="inline-flex items-center px-3 py-1.5 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm text-xs font-medium text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:ring-offset-slate-800 transition-colors">
                <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.885L17.5 5.5a2.121 2.121 0 0 0-3-3L3.58 13.42a4 4 0 0 0-.885 1.343Z" /></svg>
                Edit Target
            </a>
        </div>

        {{-- Uptime Status Logs --}}
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl mb-8">
            <div class="p-6 md:p-8">
                <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-500 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    {{ __('Uptime Check History') }}
                </h3>
                @if($statusLogs->isEmpty())
                    <div class="text-center py-10 text-slate-500 dark:text-slate-400">
                        <svg class="mx-auto h-10 w-10 mb-2 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h7.5M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 17.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                        {{ __('No uptime check history found for this target yet.') }}
                    </div>
                @else
                    <div class="overflow-x-auto border border-slate-200 dark:border-slate-700 sm:rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Timestamp</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Response Time (ms)</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Error Message</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                @foreach ($statusLogs as $log)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors duration-150">
                                        <td class="px-4 py-4 whitespace-nowrap text-slate-600 dark:text-slate-400" title="{{ $log->created_at->format('Y-m-d H:i:s') }}">
                                            {{ $log->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @php 
                                                $statusCode = $log->status_code;
                                                $statusText = 'Issue';
                                                $statusColor = 'amber';
                                                $statusIconPath = 'M12 9v3.75m0 3.75h.008v.008H12v-.008zm9-.75a9 9 0 11-18 0 9 9 0 0118 0z'; // ExclamationCircle

                                                if ($statusCode >= 200 && $statusCode < 400) {
                                                    $statusText = 'Up';
                                                    $statusColor = 'emerald';
                                                    $statusIconPath = 'M4.5 12.75l6 6 9-13.5'; // Check
                                                } elseif ($statusCode === 0 || $statusCode === -1 || $statusCode === null) {
                                                    $statusText = 'Down';
                                                    $statusColor = 'rose';
                                                    $statusIconPath = 'M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457L3 3m5.457 5.457l7.086 7.086m0 0L21 21'; // BoltSlash
                                                }
                                            @endphp
                                            <span @class([
                                                'inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full',
                                                'bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300' => $statusColor === 'emerald',
                                                'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300' => $statusColor === 'rose',
                                                'bg-amber-100 text-amber-700 dark:bg-amber-700/30 dark:text-amber-300' => $statusColor === 'amber',
                                            ])>
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $statusIconPath }}" /></svg>
                                                {{ $statusCode ?? 'N/A' }} - {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-slate-600 dark:text-slate-400">{{ $log->response_time ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 text-slate-600 dark:text-slate-400">
                                            <span class="truncate block max-w-xs" title="{{ $log->error_message }}">{{ Str::limit($log->error_message, 50) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($statusLogs->hasPages())
                        <div class="mt-6 px-2">
                            {{ $statusLogs->links('pagination::tailwind', ['pageName' => 'status_logs_page']) }}
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- SSL Check Logs --}}
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl">
            <div class="p-6 md:p-8">
                <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-sky-500 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    {{ __('SSL Certificate Check History') }}
                </h3>
                @if($sslChecks->isEmpty())
                    <div class="text-center py-10 text-slate-500 dark:text-slate-400">
                        <svg class="mx-auto h-10 w-10 mb-2 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h7.5M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 17.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                        {{ __('No SSL check history found for this target yet.') }}
                    </div>
                @else
                    <div class="overflow-x-auto border border-slate-200 dark:border-slate-700 sm:rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Checked At</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Valid?</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Expires At</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Days Left</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Issuer</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Error Message</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                @foreach ($sslChecks as $check)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors duration-150">
                                        <td class="px-4 py-4 whitespace-nowrap text-slate-600 dark:text-slate-400" title="{{ $check->created_at->format('Y-m-d H:i:s') }}">
                                            {{ $check->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if($check->is_valid)
                                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300">
                                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    Yes
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300">
                                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zm9-.75a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    No
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-slate-600 dark:text-slate-400">
                                            {{ $check->expires_at ? $check->expires_at->format('M d, Y') : 'N/A' }}
                                            @if ($check->expires_at && $check->expires_at->isPast())
                                                <span class="text-xs text-rose-500 dark:text-rose-400 ml-1">(Expired)</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap @if($check->days_to_expiry !== null && $check->days_to_expiry <= 0) text-rose-500 dark:text-rose-400 font-semibold @elseif($check->days_to_expiry !== null && $check->days_to_expiry <= 14) text-amber-600 dark:text-amber-400 font-semibold @else text-slate-600 dark:text-slate-400 @endif">
                                            {{ $check->days_to_expiry ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-slate-600 dark:text-slate-400">
                                             <span class="truncate block max-w-xs" title="{{ $check->issued_by }}">{{ Str::limit($check->issued_by, 30) }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-slate-600 dark:text-slate-400">
                                            <span class="truncate block max-w-xs" title="{{ $check->error_message }}">{{ Str::limit($check->error_message, 50) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($sslChecks->hasPages())
                        <div class="mt-6 px-2">
                            {{ $sslChecks->links('pagination::tailwind', ['pageName' => 'ssl_checks_page']) }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- Responsive Cards for Mobile --}}
    @if(!$statusLogs->isEmpty())
        <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 md:hidden space-y-4 mt-4">
            <h4 class="text-md font-semibold text-slate-700 dark:text-slate-300 px-1">Uptime History (Recent)</h4>
            @foreach ($statusLogs as $log)
            @php 
                $statusCode = $log->status_code;
                $statusText = 'Issue';
                $statusColor = 'amber';
                $statusIconPath = 'M12 9v3.75m0 3.75h.008v.008H12v-.008zm9-.75a9 9 0 11-18 0 9 9 0 0118 0z'; // ExclamationCircle

                if ($statusCode >= 200 && $statusCode < 400) {
                    $statusText = 'Up';
                    $statusColor = 'emerald';
                    $statusIconPath = 'M4.5 12.75l6 6 9-13.5'; // Check
                } elseif ($statusCode === 0 || $statusCode === -1 || $statusCode === null) {
                    $statusText = 'Down';
                    $statusColor = 'rose';
                    $statusIconPath = 'M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457L3 3m5.457 5.457l7.086 7.086m0 0L21 21'; // BoltSlash
                }
            @endphp
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-xs text-slate-500 dark:text-slate-400" title="{{ $log->created_at->format('Y-m-d H:i:s') }}">
                            {{ $log->created_at->diffForHumans() }}
                        </div>
                        <span @class([
                            'inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full ms-2 shrink-0',
                            'bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300' => $statusColor === 'emerald',
                            'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300' => $statusColor === 'rose',
                            'bg-amber-100 text-amber-700 dark:bg-amber-700/30 dark:text-amber-300' => $statusColor === 'amber',
                        ])>
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $statusIconPath }}" /></svg>
                            {{ $statusCode ?? 'N/A' }} - {{ $statusText }}
                        </span>
                    </div>
                    <div class="text-xs text-slate-600 dark:text-slate-300">
                        <p><strong>Latency:</strong> {{ $log->response_time ?? 'N/A' }} ms</p>
                        @if($log->error_message)
                            <p class="mt-1"><strong>Error:</strong> <span class="text-rose-600 dark:text-rose-400">{{ Str::limit($log->error_message, 100) }}</span></p>
                        @endif
                    </div>
                </div>
            @endforeach
             @if ($statusLogs->hasPages())
                <div class="mt-4 px-1">
                    {{ $statusLogs->links('pagination::tailwind', ['pageName' => 'status_logs_page']) }}
                </div>
            @endif
        </div>
    @endif

    @if(!$sslChecks->isEmpty())
        <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 md:hidden space-y-4 mt-6">
            <h4 class="text-md font-semibold text-slate-700 dark:text-slate-300 px-1">SSL History (Recent)</h4>
            @foreach ($sslChecks as $check)
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-xs text-slate-500 dark:text-slate-400" title="{{ $check->created_at->format('Y-m-d H:i:s') }}">
                           Checked: {{ $check->created_at->diffForHumans() }}
                        </div>
                        @if($check->is_valid)
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                Valid
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zm9-.75a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Invalid
                            </span>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-slate-600 dark:text-slate-300">
                        <div>
                            <strong>Expires:</strong> {{ $check->expires_at ? $check->expires_at->format('M d, Y') : 'N/A' }}
                            @if ($check->expires_at && $check->expires_at->isPast())
                                <span class="text-xs text-rose-500 dark:text-rose-400 ml-1">(Expired)</span>
                            @endif
                        </div>
                        <div class="@if($check->days_to_expiry !== null && $check->days_to_expiry <= 0) text-rose-500 dark:text-rose-400 font-semibold @elseif($check->days_to_expiry !== null && $check->days_to_expiry <= 14) text-amber-600 dark:text-amber-400 font-semibold @else text-slate-600 dark:text-slate-300 @endif">
                           <strong>Days Left:</strong> {{ $check->days_to_expiry ?? 'N/A' }}
                        </div>
                        <div class="col-span-2">
                            <strong>Issuer:</strong> {{ Str::limit($check->issued_by, 40) }}
                        </div>
                        @if($check->error_message)
                            <div class="col-span-2 mt-1">
                                <strong>Error:</strong> <span class="text-rose-600 dark:text-rose-400">{{ Str::limit($check->error_message, 100) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            @if ($sslChecks->hasPages())
                <div class="mt-4 px-1">
                    {{ $sslChecks->links('pagination::tailwind', ['pageName' => 'ssl_checks_page']) }}
                </div>
            @endif
        </div>
    @endif
</x-app-layout> 