<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdicionalController extends Controller
{
    // MOSTRAR TODOS
    public function index()
    {
        try {
            $response = Http::get('http://localhost:3000/adicionales');
            $adicionales = $response->json();
            return view('adicionales', compact('adicionales'));
        } catch (\Exception $e) {
            return view('adicionales', ['adicionales' => []]);
        }
    }

    // MOSTRAR POR ID (para editar)
    public function edit($id)
    {
        try {
            $response = Http::get("http://localhost:3000/adicionales/{$id}");
            $adicional = $response->json();

            if (!$adicional) {
                return response()->json(['mensaje' => 'Adicional no encontrado'], 404);
            }

            return response()->json($adicional);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al obtener adicional'], 500);
        }
    }

    // INSERTAR
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            $response = Http::post("http://localhost:3000/adicionales", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);

            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar adicional'], 500);
        }
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            $response = Http::put("http://localhost:3000/adicionales/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);

            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al actualizar adicional'], 500);
        }
    }

    // ELIMINAR
    public function destroy($id)
    {
        try {
            $response = Http::delete("http://localhost:3000/adicionales/{$id}");
            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al eliminar adicional'], 500);
        }
    }
}
