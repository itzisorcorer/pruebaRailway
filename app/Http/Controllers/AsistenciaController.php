<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Clases;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    // Listar todas las asistencias
    public function index()
    {
        $asistencias = Asistencia::with(['usuario', 'clase'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $asistencias
        ]);
    }

    // Registrar asistencia (actualizar el estado)
    public function update(Request $request, $id_clase)
    {
        $user = Auth::user();
        
        // Verificar si la clase existe y tiene cupo disponible
        $clase = Clases::find($id_clase);
        
        if (!$clase) {
            return response()->json([
                'success' => false,
                'message' => 'Clase no encontrada'
            ], 404);
        }
        
        // Verificar si ya está registrado
        $existingAsistencia = Asistencia::where('id_usuario', $user->id)
                                        ->where('id_clase', $id_clase)
                                        ->first();
        
        if ($existingAsistencia) {
            return response()->json([
                'success' => false,
                'message' => 'Ya estás registrado en esta clase'
            ], 400);
        }
        
        // Verificar cupo disponible
        if ($clase->cupo_maximo <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'No hay cupo disponible en esta clase'
            ], 400);
        }
        
        // Crear registro de asistencia
        $asistencia = Asistencia::create([
            'id_usuario' => $user->id,
            'id_clase' => $id_clase,
            'asistio' => false // Por defecto no ha asistido aún
        ]);
        
        // Reducir el cupo máximo de la clase
        $clase->decrement('cupo_maximo');
        
        return response()->json([
            'success' => true,
            'message' => 'Registro a clase exitoso',
            'data' => $asistencia,
            'cupo_restante' => $clase->cupo_maximo
        ]);
    }
    public function getClasesByUsuario($idUsuario)
{
    // Validar que el usuario existe
    $usuario = User::find($idUsuario);
    if (!$usuario) {
        return response()->json([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ], 404);
    }

    // Obtener las asistencias con las relaciones cargadas
    $asistencias = Asistencia::with(['usuario', 'clase'])
        ->where('id_usuario', $idUsuario)
        ->get();

    return response()->json([
        'success' => true,
        'data' => $asistencias
    ]);
}
}