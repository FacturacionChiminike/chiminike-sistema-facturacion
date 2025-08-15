<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SalonController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('http://localhost:3000/salones');
            $salones = $response->json();

            return view('salones', compact('salones'));
        } catch (\Exception $e) {
            return view('salones', ['salones' => []]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'capacidad' => 'required|integer',
            'estado' => 'required|integer',
            'precio_dia' => 'required|numeric|max:99999999.99',
            'precio_noche' => 'required|numeric|max:99999999.99',
            'precio_hora_extra_dia' => 'required|numeric|max:99999999.99',
            'precio_hora_extra_noche' => 'required|numeric|max:99999999.99'
        ]);

        try {
            $token = session('token');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->post('http://localhost:3000/salones', [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'capacidad' => $request->capacidad,
                'estado' => $request->estado,
                'precio_dia' => $request->precio_dia,
                'precio_noche' => $request->precio_noche,
                'precio_hora_extra_dia' => $request->precio_hora_extra_dia,
                'precio_hora_extra_noche' => $request->precio_hora_extra_noche
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Error al insertar salón desde Node.js',
                    'detalle' => $response->body()
                ], $response->status());
            }

            return response()->json([
                'mensaje' => $response->json('mensaje') ?? 'Salón registrado correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }




    public function edit($id)
    {
        try {
            $response = Http::get('http://localhost:3000/salones');
            $salones = $response->json();

            $salon = collect($salones)->firstWhere('cod_salon', intval($id));

            if (!$salon) {
                return response()->json(['mensaje' => 'Salón no encontrado'], 404);
            }

            return response()->json($salon);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al obtener salón'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'capacidad' => 'required|integer',
            'estado' => 'required|string',
            'precio_dia' => 'required|numeric',
            'precio_noche' => 'required|numeric',
            'precio_hora_extra_dia' => 'required|numeric',
            'precio_hora_extra_noche' => 'required|numeric'
        ]);

        try {
            $token = session('token');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->put("http://localhost:3000/salones/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'capacidad' => $request->capacidad,
                'estado' => $request->estado,
                'precio_dia' => $request->precio_dia,
                'precio_noche' => $request->precio_noche,
                'precio_hora_extra_dia' => $request->precio_hora_extra_dia,
                'precio_hora_extra_noche' => $request->precio_hora_extra_noche
            ]);

            if ($response->failed()) {
                return response()->json([
                    'mensaje' => 'Error al actualizar salón desde la API'
                ], 500);
            }

            $mensaje = $response->json()['mensaje'] ?? 'Salón actualizado correctamente.';

            return response()->json(['mensaje' => $mensaje]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar salón: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $token = session('token'); 

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete("http://localhost:3000/salones/{$id}");

            if ($response->failed()) {
                return response()->json([
                    'mensaje' => 'Error al eliminar salón desde la API'
                ], 500);
            }

            $mensaje = $response->json()['mensaje'] ?? 'Salón eliminado correctamente.';

            return response()->json(['mensaje' => $mensaje]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar salón: ' . $e->getMessage()
            ], 500);
        }
    }
}
