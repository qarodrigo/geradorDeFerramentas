<?php

use App\Http\Controllers\CPFController;
use App\Http\Controllers\PISController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function () {
    Route::get('gerador_de_cpf', [CPFController::class, 'geraCPF']);
    Route::get('validador_de_cpf/{cpf}', [CPFController::class, 'validaCPF']);
    Route::get('gerador_de_pis', [PISController::class, 'geraPIS']);
    Route::get('validador_de_pis/{pis}', [PISController::class, 'validaPIS']);
});
