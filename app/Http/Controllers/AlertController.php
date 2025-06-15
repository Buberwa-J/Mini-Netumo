<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alerts = Alert::where('user_id', Auth::id())
                       ->whereNull('resolved_at') // Only show active alerts
                       ->with('target') // Eager load the target relationship
                       ->latest()
                       ->paginate(15);

        return view('alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function resolve(Alert $alert)
{
    if ($alert->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    if (!$alert->resolved_at) {
        $alert->resolved_at = now();
        $alert->save();
    }

    return redirect()->route('alerts.index')->with('success', 'Alert marked as resolved.');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alert $alert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alert $alert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alert $alert)
    {
        //
    }
}
