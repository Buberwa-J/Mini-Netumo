<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('targets', TargetController::class)->except(['show']);
    // Define history route separately as it's custom
    Route::get('/targets/{target}/history', [TargetController::class, 'history'])->name('targets.history');
    // Manual check route
    Route::post('/targets/{target}/check', [TargetController::class, 'checkNow'])->name('targets.check');

    Route::patch('/alerts/{alert}/resolve', [AlertController::class, 'resolve'])->name('alerts.resolve');
    // Alert Routes
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
});

require __DIR__ . '/auth.php';
