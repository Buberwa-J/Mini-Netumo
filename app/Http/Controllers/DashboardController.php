<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Target;
use App\Models\SslCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all targets for the user with necessary relations for the new list
        $allUserTargets = Target::where('user_id', $user->id)
            ->with([
                'latestStatusLog',
                'latestSslCheck',
                'alerts' => function ($query) {
                    $query->whereNull('resolved_at');
                }
            ])
            ->orderBy('url') // Optional: order them alphabetically
            ->get();

        $totalTargets = $allUserTargets->count();
        $activeAlertsCount = 0;

        // SSL certificates expiring within 14 days & count active alerts
        $expiringSslCount = 0;
        foreach ($allUserTargets as $target) {
            if (
                $target->latestSslCheck &&
                $target->latestSslCheck->is_valid &&
                $target->latestSslCheck->expires_at &&
                Carbon::parse($target->latestSslCheck->expires_at)->between(Carbon::now(), Carbon::now()->addDays(14))
            ) {
                $expiringSslCount++;
            }
            $activeAlertsCount += $target->alerts->count(); // alerts relation is already filtered for active
        }

        // Categorize targets by status (Up, Down, Pending)
        $targetsUp = 0;
        $targetsDown = 0; // Includes issues and alerted targets
        $targetsPending = 0;

        foreach ($allUserTargets as $target) {
            if ($target->alerts->isNotEmpty()) { // If there are any active alerts, it's counted as down
                $targetsDown++;
            } elseif ($target->latestStatusLog) {
                $statusCode = $target->latestStatusLog->status_code;
                if ($statusCode >= 200 && $statusCode < 400) { // 2xx and 3xx are UP
                    $targetsUp++;
                } else { 
                    $targetsDown++;
                }
            } else { // No status log yet
                $targetsPending++;
            }
        }

        $recentActiveAlerts = Alert::where('user_id', $user->id)
            ->whereNull('resolved_at')
            ->with('target:id,url')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTargets',
            'targetsUp',
            'targetsDown',
            'targetsPending',
            'activeAlertsCount',
            'expiringSslCount',
            'recentActiveAlerts',
            'allUserTargets' 
        ));
    }
}
