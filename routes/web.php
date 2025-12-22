<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccueilController;

// Landing page redirects to login
Route::get('/',function () {
        return redirect()->route('login.show');
    }
);

// Auth pages (views only)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');

// Auth actions
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// User home
Route::get('/accueil', [AccueilController::class, 'index'])->name('utilisateur.accueil');
