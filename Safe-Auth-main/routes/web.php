<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(\App\Http\Middleware\IsAdmin::class)->get('/admin', function () {
        $users = \App\Models\User::all();
        return view('admin', compact('users'));
    })->name('admin');

    Route::middleware(\App\Http\Middleware\IsAdmin::class)->get('/logs', function () {
        $logs = \App\Models\Log::all();
        return view('logs', compact('logs'));
    })->name('logs');
});


