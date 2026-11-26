<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
Route::get('/ping', fn () => response()->json(['status' => 'ok']));
Route::post('/users', [UserController::class, 'store']);