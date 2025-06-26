<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }




    public function autenticar(Request $request)
    {
        $usuario = $request->input('usuario');
        $contrasena = $request->input('contrasena');

        try {
            $response = Http::post('http://localhost:3000/login', [
                'usuario' => $usuario,
                'password' => $contrasena
            ]);

            $data = $response->json();

            if ($response->successful()) {

                
                if (!empty($data['usuario']['permisos'])) {
                    $permisosAdaptados = [];

                    foreach ($data['usuario']['permisos'] as $permiso) {
                        $permisosAdaptados[] = [
                            'objeto' => $permiso['objeto'],
                            'insertar' => $permiso['crear'],
                            'actualizar' => $permiso['modificar'],
                            'mostrar' => $permiso['mostrar'],
                            'eliminar' => $permiso['eliminar'],
                        ];
                    }

                    $data['usuario']['permisos'] = $permisosAdaptados;
                    session(['permisos' => $permisosAdaptados]);
                }

                
                if (!empty($data['usuario']['primer_acceso']) && $data['usuario']['primer_acceso'] == 1) {
                    session(['usuario' => $data['usuario']]);
                    return redirect()->route('primer.inicio');
                }

                
                session([
                    'token_pre_2fa' => $data['token'],
                    'usuario_pre_2fa' => $data['usuario']
                ]);

                return redirect()->route('verificar.formulario', [
                    'cod_usuario' => $data['usuario']['cod_usuario']
                ]);
            }

            return back()->with('error', $data['mensaje'] ?? 'Error al iniciar sesión');
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }




    public function recuperar(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            $response = Http::post('http://localhost:3000/api/recuperar-contrasena', [
                'correo' => $request->input('email')
            ]);

            $data = $response->json();

            if ($response->successful()) {
                return back()->with('status', $data['mensaje']);
            } else {
                return back()->with('error', $data['mensaje'] ?? 'No se pudo enviar el correo.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error al conectar con el servidor.');
        }
    }

    public function mostrarFormularioReset(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Token inválido o vencido.');
        }

        return view('resetear', compact('token'));
    }

    public function resetearContrasena(Request $request)
    {
        $request->validate([
            'nueva' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        try {
            $response = Http::put('http://localhost:3000/api/resetear-contrasena', [
                'token' => $request->input('token'),
                'nueva' => $request->input('nueva')
            ]);

            $data = $response->json();

            if ($response->successful()) {
                return redirect()->route('login')->with('status', $data['mensaje']);
            } else {
                return back()->with('error', $data['mensaje'] ?? 'No se pudo cambiar la contraseña');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error al conectar con el servidor');
        }
    }



    public function verificar2FA(Request $request)
    {
        $response = Http::post('http://localhost:3000/verificar-2fa', [
            'cod_usuario' => $request->cod_usuario,
            'codigo' => $request->codigo
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Código incorrecto o expirado');
        }

        $data = $response->json();

        // CON ESTO DEBO DE GUARDAR EL PERMISO EN VARIABLE LOCAL PARA MAS USOS---> ACORDARME PARA ELIMINAR POR SI NO SIRVE ESTO AÑADI 
        $usuario = session('usuario_pre_2fa') ?? [];

        session([
            'token' => $data['token'],
            'usuario' => $usuario,
            'permisos' => $usuario['permisos'] ?? []
        ]);

        session()->forget(['token_pre_2fa', 'usuario_pre_2fa']);

        return redirect('/dashboard')->with('success', '¡Acceso autorizado!');
    }


    public function mostrarFormulario2FA($cod_usuario)
    {
        return view('verifica', ['cod_usuario' => $cod_usuario]);
    }

    public function actualizarPasswordPrimerIngreso(Request $request)
    {
        $request->validate([
            'cod_usuario' => 'required|integer',
            'nueva_contrasena' => 'required|string|min:8',
            'confirmar_contrasena' => 'required|same:nueva_contrasena'
        ]);

        try {
            $data = [
                'cod_usuario' => $request->cod_usuario,
                'nueva_contrasena' => $request->nueva_contrasena
            ];


            $response = Http::put('http://localhost:3000/actualizar-contrasena', $data);


            if ($response->successful()) {
                session()->forget('usuario');

                return response()->json([
                    'success' => true,
                    'mensaje' => 'Contraseña actualizada correctamente.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se pudo actualizar la contraseña',
                    'error' => $response->body(),
                    'codigo_http' => $response->status()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error inesperado al conectar con el servidor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function obtenerPermisosUsuarios()
    {
        try {
            $response = Http::get('http://localhost:3000/usuarios.permisos');

            if ($response->failed()) {
                return response()->json([
                    'mensaje' => 'Error al conectar con la API de permisos',
                    'error' => $response->body()
                ], 500);
            }

            $data = $response->json();

            return response()->json([
                'mensaje' => 'Datos cargados correctamente',
                'usuarios' => $data['usuarios'],
                'objetos' => $data['objetos']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error inesperado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function vistaPermisos()
    {
        return view('userpermisos');
    }

    public function actualizarPermiso(Request $request)
    {
        $data = $request->only(['cod_rol', 'cod_objeto', 'permiso', 'valor']);


        if (!in_array($data['permiso'], ['crear', 'modificar', 'mostrar', 'eliminar'])) {
            return response()->json(['mensaje' => 'Permiso inválido'], 400);
        }

        try {
            $response = Http::put('http://localhost:3000/permisos.actualizar', $data);

            if ($response->failed()) {
                return response()->json([
                    'mensaje' => 'Error al conectar con la API de Node.js',
                    'error' => $response->body()
                ], 500);
            }

            return response()->json([
                'mensaje' => 'Permiso actualizado correctamente (Laravel)',
                'respuesta_api' => $response->json()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error inesperado al actualizar permiso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
    }
}
