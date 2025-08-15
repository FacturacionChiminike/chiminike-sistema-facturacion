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
          
            $token = session('token');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post("http://localhost:3000/inventario", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_unitario' => $request->precio_unitario,
                'cantidad_disponible' => $request->cantidad_disponible,
                'estado' => $request->estado
            ]);

            if ($response->failed()) {
                return response()->json([
                    'ok' => false,
                    'mensaje' => 'Error al insertar inventario desde la API',
                    'error_completo' => $response->body() // 🧠 esto nos da la clave
                ], 500);
            }

            $mensaje = $response->json()['mensaje'] ?? 'Inventario insertado correctamente.';

            return response()->json(['mensaje' => $mensaje]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al insertar inventario: ' . $e->getMessage()
            ], 500);
        }
    }


    // Actualizar inventar  io
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
        $token = session('token'); // 🧠 Verifica que esté bien guardado en login

        if (!$token) {
            return response()->json([
                'mensaje' => 'Token no disponible. Por favor, inicia sesión nuevamente.'
            ], 401);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->put("http://localhost:3000/inventario/{$id}", [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_unitario' => $request->precio_unitario,
            'cantidad_disponible' => $request->cantidad_disponible,
            'estado' => $request->estado
        ]);

        if ($response->failed()) {
            return response()->json([
                'mensaje' => 'Error al actualizar inventario desde la API',
                'error' => $response->body()
            ], 500);
        }

        $mensaje = $response->json()['mensaje'] ?? 'Inventario actualizado correctamente.';

        return response()->json(['mensaje' => $mensaje]);

    } catch (\Exception $e) {
        return response()->json([
            'mensaje' => 'Error al actualizar inventario: ' . $e->getMessage()
        ], 500);
    }
}


    // Eliminar inventario
  public function destroy($id)
{
    try {
        $token = session('token');

        if (!$token) {
            return response()->json([
                'mensaje' => 'Token no disponible. Vuelve a iniciar sesión.'
            ], 401);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->delete("http://localhost:3000/inventario/{$id}");

        if ($response->failed()) {
            return response()->json([
                'mensaje' => 'Error al eliminar inventario desde la API',
                'error' => $response->body()
            ], 500);
        }

        $mensaje = $response->json()['mensaje'] ?? 'Inventario eliminado correctamente.';

        return response()->json(['mensaje' => $mensaje]);

    } catch (\Exception $e) {
        return response()->json([
            'mensaje' => 'Error al eliminar inventario: ' . $e->getMessage()
        ], 500);
    }
}

}
