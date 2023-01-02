<?php

use Chapa\Controller\Test;
use Illuminate\Support\Facades\Route;

if (env('APP_ENV') != 'production') {

    Route::get('/chapa/initialize', [Test::class, 'initialize']);
    Route::get('/chapa/verify/{ref}', [Test::class, 'verify']);
    Route::get('/chapa/verifyLatest', [Test::class, 'latest']);
    Route::get('/chapa/verifyTxById/{id}', [Test::class, 'verifyById']);
} else {
    abort(404);
}
