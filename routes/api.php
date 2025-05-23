<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembresiasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('login',[LoginController::class, 'login']);

//Membresias
Route::get('membresias',[MembresiasController::class, 'index']); //listar todos
Route::get('membresias/{id}',[MembresiasController::class, 'show']);//delete
Route::post('membresias',[MembresiasController::class, 'store']); //crear 
Route::put('membresias/{id}', [MembresiasController::class, 'update']);
Route::delete('membresias/{id}',[MembresiasController::class, 'destroy']);//delete











