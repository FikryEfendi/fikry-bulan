<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;

Route::get('/tamu',          [TamuController::class, 'get']);
Route::post('/tamu/add',     [TamuController::class, 'add']);
Route::post('/tamu/add-admin', [TamuController::class, 'addAdmin']);
Route::post('/tamu/update',  [TamuController::class, 'update']);
Route::post('/tamu/delete',  [TamuController::class, 'destroy']);

Route::post('/dashboard/update', [\App\Http\Controllers\DashboardController::class, 'update']);

Route::get('/acara', [\App\Http\Controllers\AcaraController::class, 'index']);
Route::post('/acara/add', [\App\Http\Controllers\AcaraController::class, 'store']);
Route::post('/acara/update', [\App\Http\Controllers\AcaraController::class, 'update']);
Route::post('/acara/delete', [\App\Http\Controllers\AcaraController::class, 'destroy']);

Route::get('/cerita', [\App\Http\Controllers\CeritaController::class, 'index']);
Route::post('/cerita/add', [\App\Http\Controllers\CeritaController::class, 'store']);
Route::post('/cerita/update', [\App\Http\Controllers\CeritaController::class, 'update']);
Route::post('/cerita/delete', [\App\Http\Controllers\CeritaController::class, 'destroy']);

Route::get('/galeri', [\App\Http\Controllers\GaleriController::class, 'index']);
Route::post('/galeri/add', [\App\Http\Controllers\GaleriController::class, 'store']);
Route::post('/galeri/delete', [\App\Http\Controllers\GaleriController::class, 'destroy']);