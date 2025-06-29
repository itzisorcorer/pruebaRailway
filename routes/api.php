
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
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AsistenciaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
// Autenticación sii
Route::post('login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [LoginController::class, 'logout']);

// Usuario autenticado
Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'token_valid_until' => $request->user()->currentAccessToken()->expires_at
    ]);
});
    //descomentar si se quiere hacer registro por primera vez de un usuario
    //Route::post('usuarios', [UserController::class, 'store']);

*/
Route::get('/', function () {
    return response()->json(['status' => 'Laravel en Railway funcionando 🚀']);
});


    //Route::post('clases', [ClasesController::class, 'store']);
    //Route::get('clases', [ClasesController::class, 'index']);
// Membresías y usuarios (todas protegidas siksi)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('membresias', [MembresiasController::class, 'index']);
    Route::post('membresias', [MembresiasController::class, 'store']);
    Route::get('membresias/{id}', [MembresiasController::class, 'show']);
    Route::put('membresias/{id}', [MembresiasController::class, 'update']);
    Route::delete('membresias/{id}', [MembresiasController::class, 'destroy']);

    //usuario (todas protegidas siksi)
    Route::get('usuarios', [UserController::class, 'index']);
    
    //comentar la de abajo si se registrara por primera vez un usuario
    Route::post('usuarios', [UserController::class, 'store']);
    Route::get('usuarios/{id}', [UserController::class, 'show']);
    Route::put('usuarios/{id}', [UserController::class, 'update']);
    Route::delete('usuarios/{id}', [UserController::class, 'destroy']);



    //Toooodas las de clases
    Route::get('clases', [ClasesController::class, 'index']);
    Route::post('clases', [ClasesController::class, 'store']);
    Route::get('clases/{id}', [ClasesController::class, 'show']);
    Route::put('clases/{id}', [ClasesController::class, 'update']);
    Route::delete('clases/{id}', [ClasesController::class, 'destroy']);

    //aki tan toddas las ruts de asistencias:
    Route::get('asistencias', [AsistenciaController::class, 'index']);
    Route::post('clases/{id_clase}/asistir', [AsistenciaController::class, 'update']);
    
    //obtener las clases a las que el usuario asistirá:
    Route::get('/asistencias/usuario/{id}', [AsistenciaController::class, 'getClasesByUsuario']);

    // Obtener relaciones (titular -> dependientes o dependiente -> titular)
    Route::get('/usuarios/relaciones/{id}', [UserController::class, 'getRelaciones']);
});

