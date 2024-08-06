<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DjamouserController;


Route::get('/user', function (Request $request) {
  
    return $request->user();
})->middleware('auth:sanctum');

    Route::post('/store', [DjamouserController::class, 'store'])->name('getDjamoUsers.store');

