<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\DepotController;
use App\Http\Middleware\CheckSession;

// Landing page redirects to login
Route::get('/',function () {
        return redirect()->route('login.show');
    }
);

// Auth pages (views only)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');

// Auth actions
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Routes protégées par session
Route::middleware([CheckSession::class])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // User home
    Route::get('/accueil', [AccueilController::class, 'index'])->name('utilisateur.accueil');

    // Deposit page
    Route::get('/deposer', [DepotController::class, 'showForm'])->name('depot.show');

    // Dépôt action
    Route::post('/depot', [DepotController::class, 'deposer'])->name('depot.store');
});
