<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/welcome', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    $completedFiles = \App\Models\file::where('status', 'completed')->count();
    $inProgressFiles = \App\Models\file::where('status', 'in_progress')->count();
    $arrivalFiles = \App\Models\file::where('type', 'arrival')->count();
    $departureFiles = \App\Models\file::where('type', 'departure')->count();

    return Inertia::render('Dashboard', [
        'fileStats' => [
            'completed' => $completedFiles,
            'in_progress' => $inProgressFiles,
            'arrival' => $arrivalFiles,
            'departure' => $departureFiles,
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('files', FileController::class)->only(['index', 'store']);
    Route::get('files/{file}', [App\Http\Controllers\FileController::class, 'show'])->name('files.show');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
