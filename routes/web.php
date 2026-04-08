<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->to('/product');
    });
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/get_serverside_datatable', [ProductController::class, 'getServersideDatatable']);
    Route::get('/product/{id}', [ProductController::class, 'getProductById']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::post('/product', [ProductController::class, 'store']);
});