<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{

    public function index()
    {
        try {

            $responseClientes = Http::get('http://localhost:3000/clientes');
            $clientes = $responseClientes->successful() ? $responseClientes->json() : [];


            $responseMunicipios = Http::get('http://localhost:3000/municipio.date');
            $municipios = $responseMunicipios->successful() ? $responseMunicipios->json() : [];
        } catch (\Exception $e) {
            $clientes = [];
            $municipios = [];
        }

        return view('clientes', compact('clientes', 'municipios'));
    }


    public function update(Request $request, $id)
    {
        $token = session('token');
        try {
            $data = [
                "nombre_persona" => $request->nombre_persona,
                "fecha_nacimiento" => $request->fecha_nacimiento,
                "sexo" => $request->sexo,
                "dni" => $request->dni,
                "correo" => $request->correo,
                "telefono" => $request->telefono,
                "direccion" => $request->direccion,
                "cod_municipio" => $request->cod_municipio,
                "rtn" => $request->rtn,
                "tipo_cliente" => $request->tipo_cliente
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ])->put("http://localhost:3000/clientes.update/{$id}", $data);


            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Cliente actualizado correctamente'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al actualizar el cliente'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $response = Http::get("http://localhost:3000/clientes/{$id}");

            if ($response->successful()) {
                $cliente = $response->json();

                return response()->json([
                    'success' => true,
                    'data' => $cliente
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Cliente no encontrado'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $token = session('token');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete("http://localhost:3000/clientes/{$id}");

            if ($response->successful()) {
                $resultado = $response->json();
                return response()->json([
                    'success' => true,
                    'mensaje' => $resultado['mensaje'] ?? 'Cliente eliminado correctamente'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => $response->json()['mensaje'] ?? 'Error al eliminar el cliente'
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $token = session('token');

            $data = [
                "nombre_persona"   => $request->nombre_persona,
                "fecha_nacimiento" => $request->fecha_nacimiento,
                "sexo"             => $request->sexo,
                "dni"              => $request->dni,
                "correo"           => $request->correo,
                "telefono"         => $request->telefono,
                "direccion"        => $request->direccion,
                "cod_municipio"    => $request->cod_municipio,
                "rtn"              => $request->rtn,
                "tipo_cliente"     => $request->tipo_cliente
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token, //  Token de sesión
                'Accept' => 'application/json'
            ])->post("http://localhost:3000/clientes", $data);

            return response()->json([
                'success' => $response->successful(),
                'mensaje' => $response->successful()
                    ? 'Cliente registrado correctamente'
                    : 'Error al registrar cliente en Node',
                'respuesta_api' => $response->json(),
            ], $response->successful() ? 201 : 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error en Laravel: ' . $e->getMessage(),
            ], 500);
        }
    }
}
