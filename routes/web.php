<?php

use App\Livewire\Home\Index as HomeIndex;
use App\Livewire\Seguridad\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/inicio');

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/inicio', HomeIndex::class)
        ->name('inicio');

    Route::get('/configuracion', HomeIndex::class)
        ->name('configuracion');
});