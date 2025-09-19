<?php

use App\Http\Controllers\UE\UEAuthController;
use App\Http\Controllers\UE\UECharController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UEAuthController::class, 'login'])->name('ue.auth.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/characters', [UECharController::class, 'index'])->name('ue.characters.index');
    Route::get('/user', [UEAuthController::class, 'user'])->name('ue.auth.user');
    Route::post('/refresh', [UEAuthController::class, 'refresh'])->name('ue.auth.refresh');
    Route::post('/logout', [UEAuthController::class, 'logout'])->name('ue.auth.logout');
});

