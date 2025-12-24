<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\AdminCadeauController;
use App\Http\Controllers\CadeauController;

Route::get('/', function () {
    return redirect()->route('login.show');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::middleware('check.session')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/accueil', [AccueilController::class, 'index'])->name('utilisateur.accueil');
    Route::get('/deposer', [DepotController::class, 'showForm'])->name('depot.show');
    Route::post('/depot', [DepotController::class, 'deposer'])->name('depot.store');
    Route::get('/form-nombre-enfants', [CadeauController::class, 'showForm'])->name('utilisateur.form-entrer-nbr-enfants');
    Route::post('/suggestion-cadeaux', [CadeauController::class, 'suggererCadeaux'])->name('utilisateur.suggerer-cadeaux');
    Route::post('/echanger-cadeaux', [CadeauController::class, 'echangerCadeaux'])->name('utilisateur.echanger-cadeaux');
    Route::post('/valider-cadeaux', [CadeauController::class, 'validerCadeaux'])->name('utilisateur.valider-cadeaux');
});

Route::prefix('admin/cadeaux')->group(function () {
    Route::get('/', [AdminCadeauController::class, 'index'])->name('admin.cadeaux.index');
    Route::get('/create', [AdminCadeauController::class, 'create'])->name('admin.cadeaux.create');
    Route::post('/', [AdminCadeauController::class, 'store'])->name('admin.cadeaux.store');
    Route::get('/{id}/edit', [AdminCadeauController::class, 'edit'])->name('admin.cadeaux.edit');
    Route::put('/{id}', [AdminCadeauController::class, 'update'])->name('admin.cadeaux.update');
    Route::delete('/{id}', [AdminCadeauController::class, 'destroy'])->name('admin.cadeaux.destroy');
});
Route::get('/validation-depot', [DepotController::class, 'showValidation'])->name('depot.en-attente.list');
Route::post('/validation-depot', [DepotController::class, 'validerDepot'])->name('depot.valider');
Route::post('/rejet-depot', [DepotController::class, 'rejeterDepot'])->name('depot.rejeter');
Route::get('/admin/parametres/{code}', [ParametreController::class, 'edit'])->name('admin.parametres.edit');
Route::post('/admin/parametres/{code}', [ParametreController::class, 'update'])->name('admin.parametres.update');
