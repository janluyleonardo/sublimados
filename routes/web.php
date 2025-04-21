<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController; // Importa el futuro controlador
use App\Http\Controllers\Seller\InventoryController; // Crea este controlador

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:Admin'])
    ->prefix('admin') // Prefijo para URLs de admin (/admin/...)
    ->name('admin.') // Prefijo para nombres de rutas (admin.categories.index)
    ->group(function () {
        Route::resource('categories', CategoryController::class);
        // Aquí irán las rutas de Productos, Usuarios, etc. del Admin
    });

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:Vendedor'])
    ->prefix('seller') // /seller/...
    ->name('seller.') // seller.inventory.index
    ->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        // Aquí irían otras rutas específicas para vendedores si las necesitas
    });
