<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Rutas de la Tienda Pública (Frontend Estilo Vestir)
|--------------------------------------------------------------------------
*/
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/catalog', [ShopController::class, 'catalog'])->name('shop.catalog');
Route::get('/product/{id}', [ShopController::class, 'show'])->name('shop.show');

/*
|--------------------------------------------------------------------------
| Rutas del Panel Administrativo (Dashboard Inventario)
|--------------------------------------------------------------------------
*/
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');