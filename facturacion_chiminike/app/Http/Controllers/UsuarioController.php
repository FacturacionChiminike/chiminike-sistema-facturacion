<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsuarioController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $response = Http::get('http://localhost:3000/usuarios.get');
        $rolesResponse = Http::get('http://localhost:3000/role.date');
        $tiposResponse = Http::get('http://localhost:3000/tip.user');

        if ($response->successful() && $rolesResponse->successful() && $tiposResponse->successful()) {
            $usuarios = $response->json();
            $roles = $rolesResponse->json();
            $tiposUsuario = $tiposResponse->json();

            return view('usuario', compact('usuarios', 'roles', 'tiposUsuario'));
        } else {
            return back()->with('error', 'Error al cargar datos del servidor.');
        }
    }


    // Mostrar usuario por ID
    public function show($id)
    {
        $response = Http::get("http://localhost:3000/usuarios.set/{$id}");

        if ($response->successful()) {
            $usuario = $response->json();
            return response()->json($usuario); // o pasar a una vista si querés
        } else {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }
    }


    public function update(Request $request, $id)
    {
        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->put("http://localhost:3000/usuarios.update/{$id}", [
            'estado' => $request->input('estado'),
            'cod_tipo_usuario' => $request->input('cod_tipo_usuario'),
            'cod_rol' => $request->input('cod_rol')
        ]);

        if ($response->successful()) {
            return response()->json([
                'mensaje' => 'Usuario actualizado correctamente'
            ]);
        }

        return response()->json([
            'error' => 'Error al actualizar el usuario'
        ], 500);
    }
}
