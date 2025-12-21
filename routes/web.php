<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Page accueil
Route::get(
    '/',
    function () {
        return redirect()->route('login.show');
    }
)->name('home');

// Auth pages (views only)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
