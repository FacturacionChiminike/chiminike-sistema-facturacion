<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InventarioController extends Controller
{
    // Mostrar listado completo de inventario
    public function index()
    {
        try {
            $response = Http::get('http://localhost:3000/inventario');
            $inventario = $response->json();
            return view('inventario', compact('inventario'));
        } catch (\Exception $e) {
            return view('inventario', ['inventario' => []]);
        }
    }


    // Obtener inventario por ID
    public function edit($id)
    {
        try {
            $response = Http::get("http://localhost:3000/inventario/{$id}");
            $inventario = $response->json();

            if (!$inventario) {
                return response()->json(['mensaje' => 'Inventario no encontrado'], 404);
            }

            return response()->json($inventario);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al obtener inventario'], 500);
        }
    }

    // Insertar nuevo inventario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio_unitario' => 'required|numeric',
            'cantidad_disponible' => 'required|integer',
            'estado' => 'required|integer'
        ]);

        try {
            $response = Http::post("http://localhost:3000/inventario", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_unitario' => $request->precio_unitario,
                'cantidad_disponible' => $request->cantidad_disponible,
                'estado' => $request->estado
            ]);

            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar inventario'], 500);
        }
    }

    // Actualizar inventario
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio_unitario' => 'required|numeric',
            'cantidad_disponible' => 'required|integer',
            'estado' => 'required|integer'
        ]);

        try {
            $response = Http::put("http://localhost:3000/inventario/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_unitario' => $request->precio_unitario,
                'cantidad_disponible' => $request->cantidad_disponible,
                'estado' => $request->estado
            ]);

            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al actualizar inventario'], 500);
        }
    }

    // Eliminar inventario
    public function destroy($id)
    {
        try {
            $response = Http::delete("http://localhost:3000/inventario/{$id}");
            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al eliminar inventario'], 500);
        }
    }
}
