<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\AdminCadeauController;
use App\Http\Controllers\CadeauController;

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
Route::middleware('check.session')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // User home
    Route::get('/accueil', [AccueilController::class, 'index'])->name('utilisateur.accueil');

    // Deposit page
    Route::get('/deposer', [DepotController::class, 'showForm'])->name('depot.show');

    // Dépôt action
    Route::post('/depot', [DepotController::class, 'deposer'])->name('depot.store');

    // afficher la formulaire pour générer des cadeaux
    Route::get('/form-nombre-enfants', [CadeauController::class, 'showForm'])->name('utilisateur.form-entrer-nbr-enfants');
    // suggérer des cadeaux en fonction du nombre d'enfants
    Route::post('/suggestion-cadeaux', [CadeauController::class, 'suggererCadeaux'])->name('utilisateur.suggerer-cadeaux');
    // échanger des cadeaux sélectionnés
    Route::post('/echanger-cadeaux', [CadeauController::class, 'echangerCadeaux'])->name('utilisateur.echanger-cadeaux');
    // valider le choix des cadeaux
    Route::post('/valider-cadeaux', [CadeauController::class, 'validerCadeaux'])->name('utilisateur.valider-cadeaux');
});

Route::get('/validation-depot',[DepotController::class,'showValidation'])->name('depot.en-attente.list');
Route::post('/validation-depot',[DepotController::class,'validerDepot'])->name('depot.valider');
Route::post('/rejet-depot',[DepotController::class,'rejeterDepot'])->name('depot.rejeter');
// Admin: édition des paramètres (ex: COMM)
Route::get('/admin/parametres/{code}', [ParametreController::class, 'edit'])->name('admin.parametres.edit');
Route::post('/admin/parametres/{code}', [ParametreController::class, 'update'])->name('admin.parametres.update');

// Admin Cadeaux CRUD
Route::prefix('admin/cadeaux')->group(function () {
    Route::get('/', [AdminCadeauController::class, 'index'])->name('admin.cadeaux.index');
    Route::get('/create', [AdminCadeauController::class, 'create'])->name('admin.cadeaux.create');
    Route::post('/', [AdminCadeauController::class, 'store'])->name('admin.cadeaux.store');
    Route::get('/{id}/edit', [AdminCadeauController::class, 'edit'])->name('admin.cadeaux.edit');
    Route::put('/{id}', [AdminCadeauController::class, 'update'])->name('admin.cadeaux.update');
    Route::delete('/{id}', [AdminCadeauController::class, 'destroy'])->name('admin.cadeaux.destroy');
});