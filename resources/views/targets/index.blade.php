<x-app-layout>
    <x-slot name="header_title">Monitored Targets</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
            {{ __('Monitored Targets') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl">
            <div class="p-6 md:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Your Targets</h3>
                    <a href="{{ route('targets.create') }}" class="inline-flex items-center px-4 py-2 bg-sky-600 hover:bg-sky-500 text-white rounded-lg font-semibold text-sm shadow-md focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-colors">
                        <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        {{ __('Add New Target') }}
                    </a>
                </div>

                @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 rounded-lg border border-emerald-200 dark:border-emerald-700/50">
                    {{ session('success') }}
                </div>
                @elseif(session('info'))
                <div class="mb-4 p-4 bg-sky-50 dark:bg-sky-900/50 text-sky-700 dark:text-sky-300 rounded-lg border border-sky-200 dark:border-sky-700/50">
                    {{ session('info') }}
                </div>
                @endif

                @if($targets->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.564A.562.562 0 019 14.437V9.564z" />
                    </svg>
                    <h4 class="mt-2 text-lg font-semibold text-slate-800 dark:text-slate-200">No targets yet</h4>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Get started by adding a new target to monitor.</p>
                </div>
                @else
                <div class="overflow-x-auto border border-slate-200 dark:border-slate-700 sm:rounded-lg shadow-sm hidden md:block">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">URL</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="hidden md:table-cell px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Last Latency</th>
                                <th scope="col" class="hidden lg:table-cell px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">SSL Days Left</th>
                                <th scope="col" class="hidden xl:table-cell px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Last Check</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach ($targets as $target)
                            @php
                            $latestStatus = $target->latestStatusLog;
                            $latestSsl = $target->latestSslCheck;
                            $hasActiveAlert = $target->alerts->where('resolved_at', null)->isNotEmpty();

                            $statusText = 'Pending';
                            $statusColor = 'amber';
                            $statusCodeText = '';
                            $statusIconPath = '
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'; // Clock';

                            if ($latestStatus) {
                            if ($latestStatus->status_code >= 200 && $latestStatus->status_code < 400 && !$hasActiveAlert) {
                                $statusText='Up' ;
                                $statusColor='emerald' ;
                                $statusIconPath='<path stroke-linecap="round" stroke-linejoin="round" d="M12 16V8m0 0l-3.5 3.5M12 8l3.5 3.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' ; // ArrowUpCircle
                                } else {
                                $statusText='Down' ;
                                $statusColor='rose' ;
                                $statusIconPath='<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m0 0l-3.5-3.5M12 16l3.5-3.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' ; // ArrowDownCircle
                                }
                                $statusCodeText=' (' . $latestStatus->status_code . ')';
                                } else if ($hasActiveAlert) {
                                $statusText = 'Down';
                                $statusColor = 'rose';
                                $statusIconPath = '
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m0 0l-3.5-3.5M12 16l3.5-3.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'; // ArrowDownCircle
                                }

                                $sslText = 'N/A';
                                $sslColorClass = 'text-slate-500 dark:text-slate-400';
                                if ($latestSsl) {
                                if ($latestSsl->is_valid && $latestSsl->days_to_expiry !== null) {
                                $sslText = $latestSsl->days_to_expiry . ' days';
                                if ($latestSsl->days_to_expiry <= 7) $sslColorClass='text-rose-600 dark:text-rose-400 font-semibold' ;
                                    elseif ($latestSsl->days_to_expiry <= 14) $sslColorClass='text-amber-600 dark:text-amber-400 font-semibold' ;
                                        else $sslColorClass='text-emerald-600 dark:text-emerald-400' ;
                                        } elseif (!$latestSsl->is_valid) {
                                        $sslText = 'Invalid';
                                        $sslColorClass = 'text-rose-600 dark:text-rose-400 font-semibold';
                                        }
                                        }
                                        @endphp
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors duration-150">
                                            <td class="px-4 py-4 whitespace-nowrap font-medium text-slate-800 dark:text-slate-100">
                                                <a href="{{ $target->url }}" target="_blank" class="text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 break-all transition-colors" title="{{ $target->url }}">
                                                    {{ Str::limit($target->url, 40) }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span @class([ 'inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full' , 'bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300'=> $statusColor === 'emerald',
                                                    'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300' => $statusColor === 'rose',
                                                    'bg-amber-100 text-amber-700 dark:bg-amber-700/30 dark:text-amber-300' => $statusColor === 'amber',
                                                    ])>
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">{!! $statusIconPath !!}</svg>
                                                    {{ $statusText }}{{ $statusCodeText }}
                                                </span>
                                            </td>
                                            <td class="hidden md:table-cell px-4 py-4 whitespace-nowrap text-slate-500 dark:text-slate-400">
                                                {{ $target->latestStatusLog ? $target->latestStatusLog->response_time . ' ms' : 'N/A' }}
                                            </td>
                                            <td class="hidden lg:table-cell px-4 py-4 whitespace-nowrap {{ $sslColorClass }}">
                                                {{ $sslText }}
                                            </td>
                                            <td class="hidden xl:table-cell px-4 py-4 whitespace-nowrap text-slate-500 dark:text-slate-400">
                                                {{ $target->last_checked_at ? $target->last_checked_at->diffForHumans() : 'Never' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-right font-medium space-x-1 sm:space-x-2">
                                                <form method="POST" action="{{ route('targets.check', $target) }}" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-700/30 hover:bg-indigo-200 dark:hover:bg-indigo-700/50 border border-indigo-300 dark:border-indigo-600 hover:border-indigo-400 dark:hover:border-indigo-500 rounded-md transition-colors" title="Run checks now">
                                                        <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0A8.003 8.003 0 0012 20a8 8 0 007.938-7.25M4.582 9H9m7 0h4.418" />
                                                        </svg>
                                                        Check Now
                                                    </button>
                                                </form>
                                                <a href="{{ route('targets.history', $target) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-sky-700 dark:text-sky-300 bg-sky-100 dark:bg-sky-700/30 hover:bg-sky-200 dark:hover:bg-sky-700/50 border border-sky-300 dark:border-sky-600 hover:border-sky-400 dark:hover:border-sky-500 rounded-md transition-colors" title="View History">
                                                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    History
                                                </a>
                                                <a href="{{ route('targets.edit', $target) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-600 hover:bg-slate-200 dark:hover:bg-slate-500 border border-slate-300 dark:border-slate-600 hover:border-slate-400 dark:hover:border-slate-500 rounded-md transition-colors" title="Edit Target">
                                                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.212l-4 1 1-4 12.362-12.725z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('targets.destroy', $target) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this target and all its data?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-rose-700 dark:text-rose-300 bg-rose-100 dark:bg-rose-700/30 hover:bg-rose-200 dark:hover:bg-rose-700/50 border border-rose-300 dark:border-rose-600 hover:border-rose-400 dark:hover:border-rose-500 rounded-md transition-colors" title="Delete Target">
                                                        <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 px-2">
                    {{ $targets->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Responsive Cards for Mobile --}}
    @if(!$targets->isEmpty())
    <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 md:hidden space-y-4 mt-4">
        @foreach ($targets as $target)
        @php
        $latestStatus = $target->latestStatusLog;
        $latestSsl = $target->latestSslCheck;
        $hasActiveAlert = $target->alerts->where('resolved_at', null)->isNotEmpty();

        $statusText = 'Pending';
        $statusColor = 'amber';
        $statusCodeText = '';
        $statusIconPath = '
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'; // Clock';

        if ($latestStatus) {
        if ($latestStatus->status_code >= 200 && $latestStatus->status_code < 400 && !$hasActiveAlert) {
            $statusText='Up' ;
            $statusColor='emerald' ;
            $statusIconPath='<path stroke-linecap="round" stroke-linejoin="round" d="M12 16V8m0 0l-3.5 3.5M12 8l3.5 3.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' ; // ArrowUpCircle
            } else {
            $statusText='Down' ;
            $statusColor='rose' ;
            $statusIconPath='<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m0 0l-3.5-3.5M12 16l3.5-3.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' ; // ArrowDownCircle
            }
            $statusCodeText=' (' . $latestStatus->status_code . ')';
            } else if ($hasActiveAlert) {
            $statusText = 'Down';
            $statusColor = 'rose';
            $statusIconPath = '
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m0 0l-3.5-3.5M12 16l3.5-3.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'; // ArrowDownCircle
            }

            $sslText = 'N/A';
            $sslColorClass = 'text-slate-500 dark:text-slate-400';
            if ($latestSsl) {
            if ($latestSsl->is_valid && $latestSsl->days_to_expiry !== null) {
            $sslText = $latestSsl->days_to_expiry . ' days';
            if ($latestSsl->days_to_expiry <= 7) $sslColorClass='text-rose-600 dark:text-rose-400 font-semibold' ;
                elseif ($latestSsl->days_to_expiry <= 14) $sslColorClass='text-amber-600 dark:text-amber-400 font-semibold' ;
                    else $sslColorClass='text-emerald-600 dark:text-emerald-400' ;
                    } elseif (!$latestSsl->is_valid) {
                    $sslText = 'Invalid';
                    $sslColorClass = 'text-rose-600 dark:text-rose-400 font-semibold';
                    }
                    }
                    @endphp
                    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <a href="{{ $target->url }}" target="_blank" class="font-semibold text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 break-all transition-colors text-base" title="{{ $target->url }}">
                                {{ Str::limit($target->name ?: $target->url, 30) }}
                            </a>
                            <span @class([ 'inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full ms-2 shrink-0' , 'bg-emerald-100 text-emerald-700 dark:bg-emerald-700/30 dark:text-emerald-300'=> $statusColor === 'emerald',
                                'bg-rose-100 text-rose-700 dark:bg-rose-700/30 dark:text-rose-300' => $statusColor === 'rose',
                                'bg-amber-100 text-amber-700 dark:bg-amber-700/30 dark:text-amber-300' => $statusColor === 'amber',
                                ])>
                                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">{!! $statusIconPath !!}</svg>
                                {{ $statusText }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-slate-600 dark:text-slate-300 mb-3">
                            <div>
                                <span class="font-medium text-slate-500 dark:text-slate-400">Latency:</span>
                                {{ $target->latestStatusLog ? $target->latestStatusLog->response_time . ' ms' : 'N/A' }}
                            </div>
                            <div class="{{ $sslColorClass }}">
                                <span class="font-medium text-slate-500 dark:text-slate-400">SSL Health:</span>
                                {{ $sslText }}
                            </div>
                            <div class="col-span-2">
                                <span class="font-medium text-slate-500 dark:text-slate-400">Last Check:</span>
                                {{ $target->last_checked_at ? $target->last_checked_at->diffForHumans() : 'Never' }}
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 pt-2 border-t border-slate-200 dark:border-slate-700">
                            <form method="POST" action="{{ route('targets.check', $target) }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center text-xs font-semibold px-3 py-2 rounded-md text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-700/30 hover:bg-indigo-200 dark:hover:bg-indigo-700/50 border border-indigo-300 dark:border-indigo-600 hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors" title="Run checks now">
                                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0A8.003 8.003 0 0012 20a8 8 0 007.938-7.25M4.582 9H9m7 0h4.418" />
                                    </svg>
                                    Check Now
                                </button>
                            </form>
                            <a href="{{ route('targets.history', $target) }}" class="w-full inline-flex items-center justify-center text-xs font-semibold px-3 py-2 rounded-md text-sky-700 dark:text-sky-300 bg-sky-100 dark:bg-sky-700/30 hover:bg-sky-200 dark:hover:bg-sky-700/50 border border-sky-300 dark:border-sky-600 hover:border-sky-400 dark:hover:border-sky-500 transition-colors">
                                <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                History
                            </a>
                            <a href="{{ route('targets.edit', $target) }}" class="w-full inline-flex items-center justify-center text-xs font-semibold px-3 py-2 rounded-md text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-600 hover:bg-slate-200 dark:hover:bg-slate-500 border border-slate-300 dark:border-slate-600 hover:border-slate-400 dark:hover:border-slate-500 transition-colors">
                                <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.212l-4 1 1-4 12.362-12.725z" />
                                </svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('targets.destroy', $target) }}" class="w-full" onsubmit="return confirm('Are you sure you want to delete this target and all its data?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center text-xs font-semibold px-3 py-2 rounded-md text-rose-700 dark:text-rose-300 bg-rose-100 dark:bg-rose-700/30 hover:bg-rose-200 dark:hover:bg-rose-700/50 border border-rose-300 dark:border-rose-600 hover:border-rose-400 dark:hover:border-rose-500 transition-colors" title="Delete Target">
                                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-6 px-2">
                        {{ $targets->links() }}
                    </div>
    </div>
    @endif
</x-app-layout>