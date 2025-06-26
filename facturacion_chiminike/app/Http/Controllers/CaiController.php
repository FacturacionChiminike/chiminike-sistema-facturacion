<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CaiController extends Controller
{
    // Mostrar todos los CAI
    public function index()
    {
        try {
            $response = Http::get('http://localhost:3000/cai.get');
            $cai = $response->json();

            return view('cai', compact('cai'));
        } catch (\Exception $e) {
            return view('cai', ['cai' => []]);
        }
    }

    // Insertar nuevo CAI
    public function store(Request $request)
    {
        $request->validate([
            'cai' => 'required|string|max:100',
            'rango_desde' => 'required|string|max:25',
            'rango_hasta' => 'required|string|max:25',
            'fecha_limite' => 'required|date',
        ]);

        try {
            $response = Http::post('http://localhost:3000/cai', [
                'cai' => $request->cai,
                'rango_desde' => $request->rango_desde,
                'rango_hasta' => $request->rango_hasta,
                'fecha_limite' => $request->fecha_limite,
            ]);

            $respuesta = $response->json();

            return response()->json([
                'mensaje' => $respuesta['mensaje'] ?? 'CAI insertado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al insertar CAI: ' . $e->getMessage()
            ], 500);
        }
    }

    // Actualizar CAI
    public function update(Request $request, $id)
    {
        $request->validate([
            'cai' => 'required|string|max:100',
            'rango_desde' => 'required|string|max:25',
            'rango_hasta' => 'required|string|max:25',
            'fecha_limite' => 'required|date',
            'estado' => 'required|in:0,1',  
        ]);

        try {
            $response = Http::put("http://localhost:3000/cai/{$id}", [
                'cai' => $request->cai,
                'rango_desde' => $request->rango_desde,
                'rango_hasta' => $request->rango_hasta,
                'fecha_limite' => $request->fecha_limite,
                'estado' => $request->estado,
            ]);

            $respuesta = $response->json();

            return response()->json([
                'mensaje' => $respuesta['mensaje'] ?? 'CAI actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar CAI: ' . $e->getMessage()
            ], 500);
        }
    }

    // Eliminar CAI
    public function destroy($id)
    {
        try {
            $response = Http::delete("http://localhost:3000/cai/{$id}");
            $respuesta = $response->json();

            return response()->json([
                'mensaje' => $respuesta['mensaje'] ?? 'CAI eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar CAI: ' . $e->getMessage()
            ], 500);
        }
    }
}
