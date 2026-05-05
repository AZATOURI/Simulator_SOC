<?php

use App\Http\Controllers\AlertController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AlertController::class, 'dashboard'])->name('dashboard');

    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/create', [AlertController::class, 'create'])->name('alerts.create');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');

    Route::get('/alerts/{alert}', [AlertController::class, 'show'])->name('alerts.show');
    Route::get('/alerts/{alert}/edit', [AlertController::class, 'edit'])->name('alerts.edit');
    Route::put('/alerts/{alert}', [AlertController::class, 'update'])->name('alerts.update');
    Route::delete('/alerts/{alert}', [AlertController::class, 'destroy'])->name('alerts.destroy');

    Route::post('/alerts/{alert}/status', [AlertController::class, 'changeStatus'])->name('alerts.status');
    Route::post('/generate-attack', [AlertController::class, 'generateAttack'])->name('alerts.generate');

    Route::get('/history', [AlertController::class, 'history'])->name('alerts.history');
});

require __DIR__.'/auth.php';
