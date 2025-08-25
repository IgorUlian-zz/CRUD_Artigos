<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LivewireArticle;
use App\Livewire\LivewireDeveloper;
use App\Livewire\LivewireMyArticles;

Route::view('/', 'welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

Route::middleware('auth')->group(function () {

    Route::get('/articles', LivewireArticle::class)->middleware(['auth', 'verified'])->name('articles');
    Route::get('/developers', LivewireDeveloper::class)->middleware(['auth', 'verified'])->name('developers');
    Route::get('/my-articles', LivewireMyArticles::class)->middleware(['auth'])->name('my-articles');
});

require __DIR__.'/auth.php';
