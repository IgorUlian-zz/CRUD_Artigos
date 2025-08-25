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

// ROTAS TEMPORÁRIAS DE DEPURAÇÃO - REMOVER DEPOIS
Route::get('/debug-check-file', function () {
    $filePath = resource_path('views/components/auth-session-status.blade.php');

    echo "<h1>Verificando a existência do arquivo:</h1>";
    echo "<p>Caminho completo: " . $filePath . "</p>";

    if (file_exists($filePath)) {
        return "<h2>RESULTADO: ARQUIVO ENCONTRADO! :)</h2>";
    } else {
        return "<h2>RESULTADO: ARQUIVO NÃO ENCONTRADO! :(</h2>";
    }
});

Route::get('/debug-list-components', function () {
    $path = resource_path('views/components');

    echo "<h1>Listando todos os arquivos na pasta de componentes:</h1>";
    echo "<p>Caminho: " . $path . "</p>";
    echo "<pre>";
    print_r(scandir($path));
    echo "</pre>";
});

require __DIR__.'/auth.php';
