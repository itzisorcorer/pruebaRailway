
<?php
/*
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
*/


use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembresiasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Autenticación
Route::post('login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [LoginController::class, 'logout']);

// Usuario autenticado
Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'token_valid_until' => $request->user()->currentAccessToken()->expires_at
    ]);
});

// Membresías y usuarios (todas protegidas siksi)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('membresias', [MembresiasController::class, 'index']);
    Route::post('membresias', [MembresiasController::class, 'store']);
    Route::get('membresias/{id}', [MembresiasController::class, 'show']);
    Route::put('membresias/{id}', [MembresiasController::class, 'update']);
    Route::delete('membresias/{id}', [MembresiasController::class, 'destroy']);

    //usuario (todas protegidas siksi)
        Route::get('usuarios', [UserController::class, 'index']);
        Route::post('usuarios', [UserController::class, 'store']);
        Route::get('usuarios/{id}', [UserController::class, 'show']);
        Route::put('usuarios/{id}', [UserController::class, 'update']);
        Route::delete('usuarios/{id}', [UserController::class, 'destroy']);
});

