<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show'])->whereNumber('id');
Route::put('/users/{id}', [UserController::class, 'update'])->whereNumber('id');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->whereNumber('id');