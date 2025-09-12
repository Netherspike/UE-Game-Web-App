<?php

use App\Http\Controllers\UE\UEAuthController;
use App\Http\Controllers\UE\UECharController;
use Illuminate\Support\Facades\Route;

Route::get('/characters', [UECharController::class, 'index'])
    ->middleware('auth:sanctum');

Route::post('/login', [UEAuthController::class, 'login']);
