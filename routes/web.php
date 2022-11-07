<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login'])->name('login');

Route::post('/app/connexion', [AuthController::class, 'connexion'])->name('connexion');

Route::middleware(['auth'])->group(function () {
    Route::get('/app/deconnexion', [AuthController::class, 'deconnexion'])->name('deconnexion');

    Route::get('/app/client', [DataController::class, 'client'])->name('app.client');
    Route::post('/app/client', [DataController::class, 'client_a']);
    Route::delete('/app/client', [DataController::class, 'client_d']);


    //======================== ADMIN
    Route::get('/admin', [AdminController::class, 'accueil'])->name('admin.accueil');
    Route::get('/admin/client', [AdminController::class, 'client'])->name('admin.client');
    Route::get('/admin/chauffeur', [AdminController::class, 'chauffeur'])->name('admin.chauffeur');
    Route::get('/admin/poubelle', [AdminController::class, 'poubelle'])->name('admin.poubelle');
});


Route::post('/app/connexion', [AuthController::class, 'connexion'])->name('app.connexion');
