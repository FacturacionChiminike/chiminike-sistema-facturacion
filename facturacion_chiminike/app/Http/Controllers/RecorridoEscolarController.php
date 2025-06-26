<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecorridoEscolarController extends Controller
{
    // MOSTRAR TODOS LOS PAQUETES
    public function index()
    {
        try {
            $response = Http::get('http://localhost:3000/paquetes');
            $paquetes = $response->json();
            return view('recorridos', compact('paquetes'));
        } catch (\Exception $e) {
            return view('recorridos', ['paquetes' => []]);
        }
    }

    // MOSTRAR PAQUETE POR ID
    public function edit($id)
    {
        try {
            $response = Http::get("http://localhost:3000/paquetes/{$id}");
            $paquete = $response->json();

            if (!$paquete) {
                return response()->json(['mensaje' => 'Paquete no encontrado'], 404);
            }

            return response()->json($paquete);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al obtener paquete'], 500);
        }
    }

    // INSERTAR NUEVO PAQUETE
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            $response = Http::post("http://localhost:3000/paquetes", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);

            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar paquete'], 500);
        }
    }

    // ACTUALIZAR PAQUETE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            $response = Http::put("http://localhost:3000/paquetes/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);

            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al actualizar paquete'], 500);
        }
    }

    // ELIMINAR PAQUETE
    public function destroy($id)
    {
        try {
            $response = Http::delete("http://localhost:3000/paquetes/{$id}");
            $mensaje = $response->json();

            return response()->json(['mensaje' => $mensaje['mensaje']]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al eliminar paquete'], 500);
        }
    }
}
