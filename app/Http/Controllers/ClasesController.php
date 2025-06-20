<?php

namespace App\Http\Controllers;

use App\Models\Clases;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClasesController extends Controller
{
    // Obtener todas las clases (con paginación)
    public function index()
    {
        $clases = Clases::paginate(10);
        return response()->json([
            'success' => true,
            'data' => $clases
        ]);
    }

    // Crear nueva clase
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'cupo_maximo' => 'required|integer|min:1',
            'dias_disponibles' => [
                'required',
                Rule::in(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])
            ],
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $clase = Clases::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Clase creada exitosamente',
            'data' => $clase
        ], 201);
    }

    // Mostrar una clase específica
    public function show($id)
    {
        $clase = Clases::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $clase
        ]);
    }

    // Actualizar clase
    public function update(Request $request, $id)
    {
        $clase = Clases::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'descripcion' => 'nullable|string',
            'cupo_maximo' => 'sometimes|integer|min:1',
            'dias_disponibles' => [
                'sometimes',
                Rule::in(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])
            ],
            'hora_inicio' => 'sometimes|date_format:H:i',
            'hora_fin' => 'required_with:hora_inicio|date_format:H:i|after:hora_inicio',
        ]);

        $clase->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Clase actualizada',
            'data' => $clase
        ]);
    }

    // Eliminar clase
    public function destroy($id)
    {
        $clase = Clases::findOrFail($id);
        $clase->delete();

        return response()->json([
            'success' => true,
            'message' => 'Clase eliminada'
        ]);
    }

    // Endpoint adicional: Clases por día
    public function porDia($dia)
    {
        if (!in_array($dia, ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])) {
            return response()->json([
                'success' => false,
                'message' => 'Día no válido'
            ], 400);
        }

        $clases = Clases::where('dias_disponibles', $dia)->get();

        return response()->json([
            'success' => true,
            'data' => $clases
        ]);
    }
}