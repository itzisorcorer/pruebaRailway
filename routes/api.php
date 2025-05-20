<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('login',[LoginController::class, 'login']);

Route::get('clientes/lista', [ClientesController::class, 'listaClientesAPI']);
Route::get('tecnicos/lista', [ClientesController::class, 'listaTecnicosAPI']);
Route::post('polizas/lista', [PolizasController::class, 'listaPolizasAPI']);

Route::post('servicio/nuevo', [ServiciosController::class, 'store']);
Route::post('servicios/eliminar', [ServiciosController::class, 'delete']);
Route::post('servicio', [ServiciosController::class, 'index']);

Route::get('servicios', [ServiciosController::class, 'list']);