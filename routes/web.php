<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LivewireArticle;
use App\Livewire\LivewireDeveloper;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::get('/articles', LivewireArticle::class)->name('articles')->middleware(['auth', 'verified']);
    Route::get('/developers', LivewireDeveloper::class)->name('developers')->middleware(['auth', 'verified']);

// });
require __DIR__.'/auth.php';
