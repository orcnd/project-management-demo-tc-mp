<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\AuthController::class)->group(
    function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::get('/me', 'me')->middleware('auth:sanctum');
    }
);


Route::apiResource(
    'projects',
    \App\Http\Controllers\ProjectController::class
)->middleware('auth:sanctum');

Route::apiResource(
    'tasks',
    \App\Http\Controllers\TaskController::class
)->middleware('auth:sanctum');
