<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\Request;

class MembresiasController extends Controller
{
    // GET /membresias (Listar todas las membresías)
    public function index()
    {
        
        $membresias = Membresia::join('users', 'users.id', 'membresias.id_usuario')
        ->select('membresias.*', 'users.name as cliente')
        ->get();
        return $membresias;
    }

    // GET /membresias/{id} (Mostrar una membresía específica)
    public function show($id)
    {
        $membresia = Membresia::find($id);
        
        if (!$membresia) {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }

        return response()->json($membresia);
    }

    // POST /membresias (Crear nueva membresía)
    public function store(Request $request)
    {
        //$validated = $request->all();
        $validated = $request->validate([
            'id_usuario' => 'required|integer|exists:users,id', //validar que sea un entero
            'tipo_pago' => 'required|in:Clase,Mensual',
            'fecha_inicio' => 'required|date|after_or_equal:today', //no puede ser antes de hoy
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio', //esta fecha no puede ser menor a la fecha_inicio
            'costo' => 'required|numeric|min:20',
            'estado' => 'required|in:Activa,Vencida,Cancelada'
        ]);

        $membresia = Membresia::create($validated);

        return "Ok";
        
    }

    // PUT /membresias/{id} (Actualizar membresía existente)
    public function update(Request $request, $id)
    {
        $membresia = Membresia::find($id);
        
        if (!$membresia) {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }

        $validated = $request->validate([
            'id_usuario' => 'sometimes|exists:users,id',
            'tipo_pago' => 'sometimes|in:Clase,Mensual',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'nullable|date',
            'costo' => 'sometimes|numeric|min:20',
            'estado' => 'sometimes|in:Activa,Vencida,Cancelada'
        ]);

        $membresia->update($validated);

        return response()->json([
            'message' => 'Membresía actualizada exitosamente',
            'data' => $membresia
        ]);
    }

    // DELETE /membresias/{id} (Eliminar membresía)
    public function destroy($id)
    {
        $membresia = Membresia::find($id);
        
        if (!$membresia) {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }

        $membresia->delete();

        return response()->json(['message' => 'Membresía eliminada correctamente']);
    }
}