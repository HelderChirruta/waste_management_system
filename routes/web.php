<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Operador\EntradaResiduoController;
use App\Http\Controllers\Operador\MovimentacaoController;
use App\Http\Controllers\Relatorios\RelatorioController;

// Rotas públicas
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    
    // Dashboard por perfil
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/gestor/dashboard', function () {
        return view('gestor.dashboard');
    })->name('gestor.dashboard');
    
    Route::get('/operador/dashboard', function () {
        return redirect()->route('operador.entradas.index');
    })->name('operador.dashboard');
    
    // Módulo Administrativo
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });
    
    // Módulo Operador
    Route::prefix('operador')->name('operador.')->group(function () {
        Route::resource('entradas', EntradaResiduoController::class);
        Route::resource('movimentacoes', MovimentacaoController::class);
    });
    
    // Módulo de Relatórios
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/dashboard', [RelatorioController::class, 'dashboard'])->name('dashboard');
        Route::get('/exportar-pdf', [RelatorioController::class, 'exportarPdf'])->name('exportar-pdf'); // Nome alterado para 'exportar-pdf'
        Route::get('/catadores', [RelatorioController::class, 'estatisticasCatadores'])->name('catadores');
    });
});

// Fallback para rotas não encontradas
Route::fallback(function () {
    return redirect()->route('login');
});