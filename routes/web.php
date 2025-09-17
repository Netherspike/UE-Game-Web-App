<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\CharacterController;
use App\Http\Controllers\Admin\CharacterManagementController;
use App\Http\Controllers\Admin\ItemManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
    Route::resource('mycharacters', CharacterController::class)
        ->parameters(['mycharacters' => 'character']);

    Route::middleware(IsAdmin::class)->group(function () {
        Route::resource('items', ItemManagementController::class);
        Route::resource('users', UserManagementController::class);
        Route::resource('characters', CharacterManagementController::class);
    });
});
