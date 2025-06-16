<?php

use App\Http\Controllers\HomeController;
use App\Http\Middleware\MultiGuardAuth;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', [HomeController::class, 'index']);
Route::get('/get-rekap-per-aum', [HomeController::class, 'rekapAum']);

Route::get('/download/{filename}', function ($path) {
    // Hindari path traversal (keamanan)
    if (Str::contains($path, ['..'])) {
        abort(403, 'Invalid file path.');
    }

    $fullPath = storage_path("app/private/{$path}");

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->download($fullPath);
})->where('filename', '.*')->name('download.document')
    ->middleware(MultiGuardAuth::class);
