<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UndanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TamuController;

Route::get('/', [UndanganController::class, 'index'])->name('undangan');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/api/tamu/add-admin', [TamuController::class, 'addAdmin']);