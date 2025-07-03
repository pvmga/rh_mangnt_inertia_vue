<?php

use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canResetPassword' => Route::has('password.request'),
        'status' => session('status'),
    ]);
})->name('login');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // --------------------
    // Rotas de DEPARTAMENTOS
    // --------------------
    Route::get('/departamentos', [DepartamentosController::class, 'index'])->name('departamentos.index');
    Route::post('/departamentos', [DepartamentosController::class, 'store'])->name('departamentos.store');
    Route::put('/departamentos/{departamentos}', [DepartamentosController::class, 'update'])->name('departamentos.update');
    Route::delete('/departamentos/{departamentos}', [DepartamentosController::class, 'destroy'])->name('departamentos.destroy');

    // --------------------
    // Rotas de USUARIOS
    // --------------------
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{user}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{user}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

    // --------------------
    // Rotas de FINANCEIRO
    // --------------------
    Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro.index');

});

// PERFIL
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
