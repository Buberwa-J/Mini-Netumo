<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\StatusLog;
use App\Models\SslCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Console\Commands\MonitorSites; // Import the command

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targets = Target::where('user_id', Auth::id())
                         ->with('latestStatusLog', 'latestSslCheck') 
                         ->paginate(10);
        return view('targets.index', compact('targets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('targets.create');
    }

    /**
     * Prepare URL by ensuring it has a https scheme.
     */
    private function prepareUrl(string $url): string
    {
        $url = trim($url);
        if (empty($url)) {
            return '';
        }

        // If the user enters only a domain (e.g. www.google.com), prepend https://
        if (!preg_match('~^https?://~i', $url)) {
            $url = 'https://' . $url;
        } elseif (preg_match('~^http://~i', $url)) {
            $url = preg_replace('~^http://~i', 'https://', $url);
        }
        return $url;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $preparedUrl = $this->prepareUrl($request->input('url'));
        // Update the request with the prepared URL for validation
        $request->merge(['url' => $preparedUrl]);

        $validated = $request->validate([
            'url' => [
                'required',
                'url:https', 
                'max:2048',
                Rule::unique('targets')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
        ]);

        Auth::user()->targets()->create([
            'url' => $validated['url'],
        ]);

        return redirect()->route('targets.index')->with('success', 'Target ' . $validated['url'] . ' added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        // Ensure the user owns the target
        if ($target->user_id !== Auth::id()) {
            abort(403);
        }
        return redirect()->route('targets.history', $target);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        if ($target->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('targets.edit', compact('target'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Target $target)
    {
        if ($target->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $preparedUrl = $this->prepareUrl($request->input('url'));
        $request->merge(['url' => $preparedUrl]);

        $validated = $request->validate([
            'url' => [
                'required',
                'url:https',
                'max:2048',
                Rule::unique('targets')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($target->id),
            ],
        ]);

        $target->update([
            'url' => $validated['url'],
        ]);

        return redirect()->route('targets.index')->with('success', 'Target ' . $validated['url'] . ' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        if ($target->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $target->delete();

        return redirect()->route('targets.index')->with('success', 'Target ' . $target->url . ' deleted successfully!');
    }

    /**
     * Display the monitoring history for a specific target.
     */
    public function history(Target $target)
    {
        if ($target->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $statusLogs = StatusLog::where('target_id', $target->id)
                               ->orderBy('created_at', 'desc')
                               ->paginate(15, ['*'], 'status_logs_page');

        $sslChecks = SslCheck::where('target_id', $target->id)
                             ->orderBy('created_at', 'desc')
                             ->paginate(15, ['*'], 'ssl_checks_page');

        return view('targets.history', compact('target', 'statusLogs', 'sslChecks'));
    }

    /**
     * Manually trigger a check for a specific target.
     */
    public function checkNow(Request $request, Target $target, MonitorSites $monitorCommand)
    {
        if ($target->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // This is mainly for testing purposes. It wasn't part of the assignment but is a nice addition. 
            Log::info("Manual check initiated for target ID {$target->id} by user ID " . Auth::id());

            $monitorCommand->checkUptime($target);
            $monitorCommand->checkSslCertificate($target);
            
            Log::info("Manual check completed for target ID {$target->id}");
            return redirect()->route('targets.history', $target)->with('success', 'Checks for ' . $target->url . ' initiated successfully. Results will appear soon.');

        } catch (\Exception $e) {
            Log::error("Error during manual check for target ID {$target->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to initiate checks for ' . $target->url . '. Error: ' . $e->getMessage());
        }
    }
}
