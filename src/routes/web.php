<?php

use Chapa\Controller\ChapaController;
use Illuminate\Support\Facades\Route;


Route::get('/chapa', [ChapaController::class, 'index']);
