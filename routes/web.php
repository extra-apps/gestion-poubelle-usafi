<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChauffeurControlleur;
use App\Http\Controllers\ClientControlleur;
use App\Http\Controllers\DataController;
use App\Http\Controllers\PaymentController;
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
    Route::post('/admin/client/{id}', [AdminController::class, 'client_maj'])->name('admin.client.maj');
    Route::get('/admin/chauffeur', [AdminController::class, 'chauffeur'])->name('admin.chauffeur');
    Route::get('/admin/poubelle', [AdminController::class, 'poubelle'])->name('admin.poubelle');
    Route::get('/admin/paiement', [AdminController::class, 'paiement'])->name('admin.paiement');
    Route::get('/admin/config', [AdminController::class, 'config'])->name('admin.config');

    //====================== CHAUFFEUR
    Route::get('/chauffeur', [ChauffeurControlleur::class, 'accueil'])->name('chauffeur.accueil');

    //====================== CLIENT
    Route::get('/client', [ClientControlleur::class, 'accueil'])->name('client.accueil');
    Route::get('/client/paiement-poubelle', [ClientControlleur::class, 'paiement_poubelle'])->name('client.paiement-poubelle');

    Route::get('/abonnement', [DataController::class, 'abonnement'])->name('client.abonnement');
});


Route::post('/payment/init', [PaymentController::class, 'initPayement'])->name('payment.init');
Route::post('/payment/check/{ref?}', [PaymentController::class, 'checkPayement'])->name('payment.check');
Route::get('/payment-callback/{cb_code?}', [PaymentController::class, 'payCallBack'])->name('payment.callback');


Route::post('/app/connexion', [AuthController::class, 'connexion'])->name('app.connexion');

Route::get('/capteur', [DataController::class, 'capteur'])->name('capteur');


Route::get('/simulateur', function () {
    return view('capteur');
});
