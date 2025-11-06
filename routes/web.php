<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pacientes\Index as PacientesIndex;
use App\Livewire\Pacientes\Create as PacientesCreate;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
   
    Route::get('/pacientes', PacientesIndex::class)->name('pacientes.index');
    Route::get('/pacientes/nuevo', PacientesCreate::class)->name('pacientes.create');
});

require __DIR__.'/auth.php';
