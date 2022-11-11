<?php

use App\Http\Controllers\MobileApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//MOBILE
Route::post('/app/login', [MobileApp::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/app/logout', [MobileApp::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
