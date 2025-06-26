<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EntradaController extends Controller
{
    // Mostrar la vista principal de entradas
    public function index()
    {
        try {
            $response = Http::get('http://localhost:3000/entradas');
            $entradas = $response->json();
            return view('entradas', compact('entradas'));
        } catch (\Exception $e) {
            return view('entradas', ['entradas' => []]);
        }
    }

    // Mostrar una entrada por ID
    public function show($id)
    {
        try {
            $response = Http::get("http://localhost:3000/entradas/{$id}");
            $entrada = $response->json();
            return response()->json($entrada);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al obtener la entrada'], 500);
        }
    }

    // Insertar nueva entrada
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric',
        ]);

        try {
            $response = Http::post('http://localhost:3000/entradas', [
                'nombre' => $request->nombre,
                'precio' => $request->precio
            ]);

            return response()->json(['mensaje' => 'Entrada insertada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar la entrada'], 500);
        }
    }

    // Actualizar entrada existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric',
        ]);

        try {
            $response = Http::put("http://localhost:3000/entradas/{$id}", [
                'nombre' => $request->nombre,
                'precio' => $request->precio
            ]);

            return response()->json(['mensaje' => 'Entrada actualizada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al actualizar la entrada'], 500);
        }
    }

    // Eliminar entrada
    public function destroy($id)
    {
        try {
            $response = Http::delete("http://localhost:3000/entradas/{$id}");
            return response()->json(['mensaje' => 'Entrada eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al eliminar la entrada'], 500);
        }
    }
}
