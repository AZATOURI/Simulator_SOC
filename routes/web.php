<?php

use App\Http\Controllers\AlertController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('choose-role');
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
    Route::post('/alerts/{alert}/note', [AlertController::class, 'addNote'])->name('alerts.note');
    Route::post('/alerts/{alert}/report', [AlertController::class, 'sendReport'])->name('alerts.report');
    Route::post('/alerts/{alert}/escalate', [AlertController::class, 'escalate'])->name('alerts.escalate');

    Route::post('/generate-attack', [AlertController::class, 'generateAttack'])->name('alerts.generate');

    Route::get('/history', [AlertController::class, 'history'])->name('alerts.history');

    Route::get('/internal-threat-vault', function () {
    return response()->view('Mr_21.vault');});

    Route::get('/blue-team-ping', function () {
    return response('Agadir SOC monitoring endpoint')
        ->header('X-SOC-Flag', 'SOC{Mr.Limbo}');});
});

require __DIR__.'/auth.php';
