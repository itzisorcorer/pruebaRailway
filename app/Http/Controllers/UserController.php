<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //este metodo es el que se usa para mostrar toooodas los registros, incluye solo
        //los datos que vas a utilizar o que quieres que se vean
        return User::select('id', 'name', 'tipo_usuario')->get();
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //este metodo es para crear nuevos usuarios
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'apellido' => 'required|string|max:20',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|string|min:8',
            'telefono' => 'required|string|max:15|regex:/^[0-9()+\- ]+$/',
            'fecha_nacimiento' => 'required|date|before_or_equal:today',
            'id_cuenta_principal' => 'nullable|integer|exists:users,id',
            'tipo_usuario' => 'required|in:Administrador,Titular,Dependiente'
        ]);
        $usuario = User::create($validated);
        return "Ok";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //mostrar una membresia en especifica jsjs
        $usuario = User::find($id);
        
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //este metodo es para actualizar un usuario
        $usuario = User::find($id);
        
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|max:50|unique:users,email,' . $id,
            'telefono' => 'sometimes|string|max:15|regex:/^[0-9()+\- ]+$/',
            'tipo_usuario' => 'sometimes|in:Administrador,Titular,Dependiente',
            
        ]);
        $usuario->update($validated);

        /*
        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'data' => $usuario
        ]);
        */
        return "Ok";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //este metodo se usa para eliminar usuarios asjasj
        $usuario = User::find($id);
        
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
    public function getRelaciones($idUsuario)
    {
        try {
            $usuario = User::findOrFail($idUsuario);

            if ($usuario->tipo_usuario == 'Titular') {
                $relaciones = User::where('id_cuenta_principal', $idUsuario)
                    ->select('id', 'name', 'apellido', 'email', 'telefono', 'tipo_usuario', 'fecha_nacimiento')
                    ->get();

                return response()->json([
                    'success' => true,
                    'tipo' => 'titular',
                    'data' => $relaciones
                ]);
            } elseif ($usuario->tipo_usuario == 'Dependiente' && $usuario->id_cuenta_principal) {
                $titular = User::select('id', 'name', 'apellido', 'email', 'telefono', 'fecha_nacimiento')
                    ->find($usuario->id_cuenta_principal);

                return response()->json([
                    'success' => true,
                    'tipo' => 'dependiente',
                    'data' => $titular
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Usuario sin relaciones registradas'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}
