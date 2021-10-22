<?php

use App\Http\Controllers\MemeController;
use App\Http\Controllers\TempMemeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->get('/', fn () => Inertia::render('Welcome'))->name('home');
Route::get('/mail-sent', fn ()  => Inertia::render('Auth/MailSent'))->name('mail-sent');
Route::get('/pending-verification', fn () => Inertia::render('Auth/PendingVerification'))->name('pending-verification');

Route::middleware(['auth:sanctum', 'verified', 'lastSeen'])->group(function () {
    Route::resources(['memes' => MemeController::class]);

    Route::post('/temp-meme', [TempMemeController::class, 'create'])->name('temp-meme.create');
    Route::post('/temp-meme/delete', [TempMemeController::class, 'destroy'])->name('temp-meme.destroy');

    Route::get('/logs', fn () => Inertia::render('Logs'))->name('logs.index');
    Route::get('/info', fn () => Inertia::render('Info'))->name('info.index');
});
