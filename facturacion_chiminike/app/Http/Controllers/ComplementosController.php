<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComplementosController extends Controller
{
    public function index()
    {
        try {
               $libros = Http::get("http://localhost:3000/libros")->json() ?? [];
            $adicionales = Http::get('http://localhost:3000/adicionales')->json();
            $paquetes = Http::get('http://localhost:3000/paquetes')->json();
            $entradas = Http::get('http://localhost:3000/entradas')->json();

             return view('complementos', compact('libros', 'adicionales', 'paquetes', 'entradas'));

        } catch (\Exception $e) {
            return view('complementos', [
                'adicionales' => [],
                'paquetes' => [],
                'entradas' => [],
                'libros'=> []
            ]);
        }
    }


    // ======== ADICIONALES vvv ========
    public function storeAdicional(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            $token = session('token');

            if (!$token) {
                return response()->json([
                    'mensaje' => 'Token no disponible. Inicia sesión nuevamente.'
                ], 401);
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post('http://localhost:3000/adicionales', [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);

            $respuesta = $response->json();

            return response()->json([
                'mensaje' => $respuesta['mensaje'] ?? 'Adicional insertado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al insertar adicional: ' . $e->getMessage()
            ], 500);
        }
    }


    public function showAdicional($id)
    {
        try {
            $adicional = Http::get("http://localhost:3000/adicionales/{$id}")->json();
            return response()->json($adicional);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function updateAdicional(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            $token = session('token'); // o donde tengas guardado el JWT

            $response = Http::withToken($token)->put("http://localhost:3000/adicionales/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);

            $respuesta = $response->json();

            return response()->json([
                'mensaje' => $respuesta['mensaje'] ?? 'Adicional actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar adicional: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroyAdicional($id)
    {
        try {
            $token = session('token'); // o donde guardes el token JWT

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete("http://localhost:3000/adicionales/{$id}");

            $respuesta = $response->json();

            return response()->json([
                'mensaje' => $respuesta['mensaje'] ?? 'Adicional eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar adicional: ' . $e->getMessage()
            ], 500);
        }
    }


    // ======== PAQUETES ========

    public function storePaquete(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            $token = session('token');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post('http://localhost:3000/paquetes', [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);

            return response()->json(['mensaje' => $response->json()['mensaje'] ?? 'Paquete insertado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar paquete'], 500);
        }
    }


    public function showPaquete($id)
    {
        try {
            $paquete = Http::get("http://localhost:3000/paquetes/{$id}")->json();
            return response()->json($paquete);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function updatePaquete(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            $token = session('token');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->put("http://localhost:3000/paquetes/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);

            $respuesta = $response->json();

            return response()->json([
                'mensaje' => $respuesta['mensaje'] ?? 'Paquete actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar paquete: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroyPaquete($id)
    {
        try {
            $token = session('token');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete("http://localhost:3000/paquetes/{$id}");

            $respuesta = $response->json();

            return response()->json([
                'mensaje' => $respuesta['mensaje'] ?? 'Paquete eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar paquete: ' . $e->getMessage()
            ], 500);
        }
    }


    // ======== ENTRADAS ========

    public function storeEntrada(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric'
        ]);

        try {
            $token = session('token'); 

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post('http://localhost:3000/entradas', [
                'nombre' => $request->nombre,
                'precio' => $request->precio
            ]);

            return response()->json([
                'mensaje' => $response->json()['mensaje'] ?? 'Entrada insertada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar entrada'], 500);
        }
    }


    public function showEntrada($id)
    {
        try {
            $entrada = Http::get("http://localhost:3000/entradas/{$id}")->json();
            return response()->json($entrada);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function updateEntrada(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:100',
        'precio' => 'required|numeric'
    ]);

    try {
        $token = session('token'); 

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->put("http://localhost:3000/entradas/{$id}", [
            'nombre' => $request->nombre,
            'precio' => $request->precio
        ]);

        return response()->json([
            'mensaje' => $response->json()['mensaje'] ?? 'Entrada actualizada correctamente'
        ]);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => 'Error al actualizar entrada'], 500);
    }
}

   public function destroyEntrada($id)
{
    try {
        $token = session('token'); 

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->delete("http://localhost:3000/entradas/{$id}");

        return response()->json([
            'mensaje' => $response->json()['mensaje'] ?? 'Entrada eliminada correctamente'
        ]);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => 'Error al eliminar entrada'], 500);
    }
}
// ======== LIBROS ========

public function storeLibro(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:100',
        'autor' => 'nullable|string|max:100',
        'precio' => 'required|numeric',
        'stock' => 'required|integer'
    ]);

    try {
        Http::post('http://localhost:3000/libros', [
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'precio' => $request->precio,
            'stock' => $request->stock
        ]);
        return response()->json(['mensaje' => 'Libro insertado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => 'Error al insertar libro'], 500);
    }
}

public function showLibro($id)
{
    try {
        $libro = Http::get("http://localhost:3000/libros/{$id}")->json();
        return response()->json($libro);
    } catch (\Exception $e) {
        return response()->json([], 500);
    }
}

public function updateLibro(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required|string|max:100',
        'autor' => 'nullable|string|max:100',
        'precio' => 'required|numeric',
        'stock' => 'required|integer'
    ]);

    try {
        Http::put("http://localhost:3000/libros/{$id}", [
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'precio' => $request->precio,
            'stock' => $request->stock
        ]);
        return response()->json(['mensaje' => 'Libro actualizado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => 'Error al actualizar libro'], 500);
    }
}

public function destroyLibro($id)
{
    try {
        Http::delete("http://localhost:3000/libros/{$id}");
        return response()->json(['mensaje' => 'Libro eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => 'Error al eliminar libro'], 500);
    }
}
    
}
