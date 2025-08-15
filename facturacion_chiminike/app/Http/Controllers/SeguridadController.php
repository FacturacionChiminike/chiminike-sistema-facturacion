<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SeguridadController extends Controller
{
    public function mostrarRoles()
    {
        try {
            $response = Http::get('http://localhost:3000/roles.get');

            if ($response->successful()) {
                $roles = $response->json();
                return view('roles', ['roles' => $roles]);
            } else {
                return response()->json(['mensaje' => 'Error al obtener roles desde la API'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function insertarRol(Request $request)
    {
        try {
            // Validamos los datos recibidos
            $request->validate([
                'nombre_rol' => 'required|string|max:100',
                'descripcion_rol' => 'nullable|string|max:255',
            ]);

            // Obtenemos el token de sesión
            $token = session('token'); // Asegúrate de tenerlo almacenado en sesión

            // Consumimos la API con el token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post('http://localhost:3000/roles', [
                'nombre_rol' => $request->nombre_rol,
                'descripcion_rol' => $request->descripcion_rol,
            ]);

            if ($response->successful()) {
                return response()->json(['mensaje' => 'Rol registrado correctamente']);
            } else {
                return response()->json(['mensaje' => 'Error al insertar el rol'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function actualizarRol(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'descripcion' => 'nullable|string|max:255',
                'estado' => 'required|integer'
            ]);

            // Obtener token de la sesión
            $token = session('token');

            // Hacer la solicitud con el token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->put("http://localhost:3000/roles/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'estado' => $request->estado
            ]);

            if ($response->successful()) {
                return response()->json(['mensaje' => 'Rol actualizado correctamente']);
            } else {
                return response()->json(['mensaje' => 'Error al actualizar el rol'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function eliminarRol($id)
    {
        try {
            // Obtener el token desde la sesión
            $token = session('token');

            // Llamar la API con el token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete("http://localhost:3000/roles/{$id}");

            if ($response->successful()) {
                return response()->json(['mensaje' => 'Rol eliminado correctamente']);
            } else {
                return response()->json(['mensaje' => 'Error al eliminar el rol'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function mostrarPermisos()
    {
        try {
            // Obtener los permisos
            $responsePermisos = Http::get('http://localhost:3000/permisos');
            $permisos = $responsePermisos->successful() ? $responsePermisos->json() : [];

            // Obtener los roles
            $responseRoles = Http::get('http://localhost:3000/role.date');
            $roles = $responseRoles->successful() ? $responseRoles->json() : [];

            // Obtener los objetos
            $responseObjetos = Http::get('http://localhost:3000/object.date');
            $objetos = $responseObjetos->successful() ? $responseObjetos->json() : [];

            // Enviar todo junto a la vista
            return view('permisos', compact('permisos', 'roles', 'objetos'));
        } catch (\Exception $e) {
            // En caso de error, devolver la vista vacía pero sin romper
            return view('permisos', [
                'permisos' => [],
                'roles' => [],
                'objetos' => []
            ]);
        }
    }


    public function insertarPermiso(Request $request)
    {
        try {
            $token = session('token'); // ⬅️ Obtenemos el token de la sesión

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post('http://localhost:3000/permisos', [
                'cod_rol' => $request->cod_rol,
                'cod_objeto' => $request->cod_objeto,
                'nombre' => $request->nombre,
                'crear' => $request->crear,
                'modificar' => $request->modificar,
                'mostrar' => $request->mostrar,
                'eliminar' => $request->eliminar,
            ]);

            if ($response->successful()) {
                $resultado = $response->json();

                return response()->json([
                    'success' => true,
                    'message' => $resultado['mensaje']
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear permiso'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizarPermiso(Request $request, $id)
    {
        try {
            $token = session('token'); // 🔐 Token JWT desde sesión

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->put("http://localhost:3000/permisos/{$id}", [
                'cod_rol' => $request->cod_rol,
                'cod_objeto' => $request->cod_objeto,
                'nombre' => $request->nombre,
                'crear' => $request->crear,
                'modificar' => $request->modificar,
                'mostrar' => $request->mostrar,
                'eliminar' => $request->eliminar,
            ]);

            if ($response->successful()) {
                $resultado = $response->json();

                return response()->json([
                    'success' => true,
                    'message' => $resultado['mensaje'] ?? 'Permiso actualizado correctamente'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar permiso'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function mostrarPermisoPorId($id)
    {
        try {
            $response = Http::get("http://localhost:3000/permisos/{$id}");

            if ($response->successful()) {
                $permiso = $response->json();

                return response()->json([
                    'success' => true,
                    'data' => $permiso[0]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el permiso'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 200);
        }
    }
    public function eliminarPermiso($id)
    {
        try {
            $token = session('token');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete("http://localhost:3000/permisos/{$id}");

            if ($response->successful()) {
                $resultado = $response->json();

                return response()->json([
                    'success' => true,
                    'message' => $resultado['mensaje'] ?? 'Permiso eliminado correctamente'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar permiso'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
