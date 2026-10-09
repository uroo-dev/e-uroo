<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login_index'])->name('login');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
