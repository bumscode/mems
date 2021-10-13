<?php

use App\Http\Controllers\MemeController;
use App\Http\Controllers\TempMemeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth:sanctum', 'verified', 'lastSeen'])->group(function () {
    Route::resources(['memes' => MemeController::class]);

    Route::post('/temp-meme', [TempMemeController::class, 'create'])->name('temp-meme.create');
    Route::post('/temp-meme/delete', [TempMemeController::class, 'destroy'])->name('temp-meme.destroy');

    Route::get('/logs', function () {
        return Inertia::render('Logs');
    })->name('logs.index');

    Route::get('/info', function () {
        return Inertia::render('Info');
    })->name('info.index');
});
