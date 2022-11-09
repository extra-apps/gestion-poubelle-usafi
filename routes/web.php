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

    Route::get('/app/chauffeur', [DataController::class, 'chauffeur'])->name('app.chauffeur');
    Route::post('/app/chauffeur', [DataController::class, 'chauffeur_a']);
    Route::delete('/app/chauffeur', [DataController::class, 'chauffeur_d']);

    Route::get('/app/poubelle', [DataController::class, 'poubelle'])->name('app.poubelle');
    Route::post('/app/poubelle', [DataController::class, 'poubelle_a']);
    Route::delete('/app/poubelle', [DataController::class, 'poubelle_d']);

    Route::get('/app/paiement', [DataController::class, 'paiement'])->name('app.paiement');

    Route::post('/app/config', [DataController::class, 'config'])->name('app.config');
    Route::post('/app/evacuateur', [DataController::class, 'evacuateur'])->name('app.evacuateur');


    //======================== ADMIN
    Route::get('/admin', [AdminController::class, 'accueil'])->name('admin.accueil');
    Route::get('/admin/client', [AdminController::class, 'client'])->name('admin.client');
    Route::get('/admin/chauffeur', [AdminController::class, 'chauffeur'])->name('admin.chauffeur');
    Route::get('/admin/poubelle', [AdminController::class, 'poubelle'])->name('admin.poubelle');
    Route::get('/admin/paiement', [AdminController::class, 'paiement'])->name('admin.paiement');
    Route::get('/admin/config', [AdminController::class, 'config'])->name('admin.config');
});


Route::post('/app/connexion', [AuthController::class, 'connexion'])->name('app.connexion');
