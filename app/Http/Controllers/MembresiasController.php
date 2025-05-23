<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\Request;

class MembresiasController extends Controller
{
    // GET /membresias (Listar todas las membresías)
    public function index()
    {
        return response()->json(Membresia::all());
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
            'id_usuario' => 'required|exists:users,id',
            'tipo_pago' => 'required|in:Clase,Mensual',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'costo' => 'required|numeric',
            'estado' => 'required|in:Activa,Vencida,Cancelada'
        ]);

        $membresia = Membresia::create($validated);

        return response()->json([
            'message' => 'Membresía creada exitosamente',
            'data' => $membresia
        ], 201);
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
            'costo' => 'sometimes|numeric',
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