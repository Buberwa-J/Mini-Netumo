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