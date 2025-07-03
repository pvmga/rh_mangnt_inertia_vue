<?php

use App\Http\Controllers\DepartamentosController;
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
    Route::get('/financeiro', function () {
        return Inertia::render('Financeiro');
    })->name('financeiro');

    // --------------------
    // Rotas de DEPARTAMENTOS
    // --------------------
    // Listar todos os departamentos (GET /departamentos)
    Route::get('/departamentos', [DepartamentosController::class, 'index'])->name('departamentos.index');
    // Obter dados para tabela (GET /departamentos/lista)
    // Route::get('/departamentos/lista', [DepartamentosController::class, 'list'])->name('departamentos.list');
    // Criar novo departamento (POST /departamentos)
    Route::post('/departamentos', [DepartamentosController::class, 'store'])->name('departamentos.store');
    // Atualizar departamento (PUT /departamentos/{id})
    Route::put('/departamentos/{id}', [DepartamentosController::class, 'update'])->name('departamentos.update');
    // (Opcional) Deletar departamento (DELETE /departamentos/{id})
    Route::delete('/departamentos/{id}', [DepartamentosController::class, 'destroy'])->name('departamentos.destroy');


    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    // Route::get('/usuarios/lista', [UsuariosController::class, 'list'])->name('usuarios.list');
    Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{user}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{user}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
});

// PERFIL
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
