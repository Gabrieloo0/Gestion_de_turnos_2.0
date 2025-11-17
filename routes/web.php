<?php

use App\Livewire\Empleados\Create as EmpleadosCreate;
use App\Livewire\Pacientes\Index as PacientesIndex;
use App\Livewire\Pacientes\Create as PacientesCreate;
use Illuminate\Support\Facades\Route;

// 👉 Ir siempre al login al entrar a "/"
Route::redirect('/', '/login');

Route::view('/welcome', 'welcome')->name('welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'role:Super Admin,Profesional'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/pacientes', PacientesIndex::class)->name('pacientes.index');
    Route::get('/pacientes/nuevo', PacientesCreate::class)->name('pacientes.create');
});

Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::get('/empleados/nuevo', EmpleadosCreate::class)->name('empleados.create');
});

require __DIR__.'/auth.php';
