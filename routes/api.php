<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/webhook',[\App\Http\Controllers\Api\PagamentoController::class,'webhook']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
