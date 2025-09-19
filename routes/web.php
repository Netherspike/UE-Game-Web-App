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

    // Use of singleton to create routes without id parameters as there is only for authenticated user
    Route::singleton('account', AccountController::class)->destroyable();

    // Change 'mycharacters' to 'character' to match method signatures
    Route::resource('mycharacters', CharacterController::class)
        ->parameters(['mycharacters' => 'character']);

    Route::middleware(IsAdmin::class)->group(function () {
        Route::resource('items', ItemManagementController::class);
        Route::resource('users', UserManagementController::class);
        Route::resource('characters', CharacterManagementController::class);
    });
});
