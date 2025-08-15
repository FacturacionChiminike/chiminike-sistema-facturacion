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


    public function autenticarDesdeJS(Request $request)
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

if (!empty($data['usuario']['primer_acceso']) && $data['usuario']['primer_acceso'] == 1) {
    session([
        'token'   => $data['token'] ?? null,
        'usuario' => $data['usuario'] ?? null
    ]);

    return response()->json([
        'success' => true,
        'primer_acceso' => true,
        // Pasar también el cod_usuario por URL para que el JS lo use como respaldo
        'redirect' => route('primer.acceso') . '?cod_usuario=' . ($data['usuario']['cod_usuario'] ?? ''),
        'usuario' => [
            'cod_usuario' => $data['usuario']['cod_usuario'] ?? null
        ]
    ]);
}



                session([
                    'token_pre_2fa' => $data['token'],
                    'usuario_pre_2fa' => $data['usuario']
                ]);

                return response()->json([
                    'success' => true,
                    'requiere2FA' => true,
                    'usuario' => $data['usuario'],
                    'mensaje' => $data['mensaje'] ?? 'Se envió código de verificación al correo'
                ]);
            }

            return response()->json([
                'success' => false,
                'mensaje' => $data['mensaje'] ?? 'Credenciales incorrectas'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión con el servidor'
            ], 500);
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
                if ($request->expectsJson()) {
                    return response()->json(['mensaje' => $data['mensaje']], 200);
                }
                return back()->with('status', $data['mensaje']);
            } else {
                $mensaje = $data['mensaje'] ?? 'No se pudo enviar el correo.';
                if ($request->expectsJson()) {
                    return response()->json(['error' => $mensaje], 400);
                }
                return back()->with('error', $mensaje);
            }
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Error al conectar con el servidor.'], 500);
            }
            return back()->with('error', 'Error al conectar con el servidor.');
        }
    }

    public function mostrarFormularioReset(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('logn')->with('error', 'Token inválido o vencido.');
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
                return redirect()->route('logn')->with('status', $data['mensaje']);
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
            return response()->json([
                'success' => false,
                'mensaje' => 'Código incorrecto o expirado'
            ], 401);
        }

        $data = $response->json();
        $usuario = session('usuario_pre_2fa') ?? [];

        // Procesar permisos como antes
        if (!empty($usuario['permisos'])) {
            $permisosAdaptados = [];

            foreach ($usuario['permisos'] as $permiso) {
                $permisosAdaptados[] = [
                    'objeto' => $permiso['objeto'],
                    'insertar' => $permiso['crear'],
                    'actualizar' => $permiso['modificar'],
                    'mostrar' => $permiso['mostrar'],
                    'eliminar' => $permiso['eliminar'],
                ];
            }

            $usuario['permisos'] = $permisosAdaptados;
            session(['permisos' => $permisosAdaptados]);
        }

        session([
            'token' => $data['token'],
            'usuario' => $usuario
        ]);

        session()->forget(['token_pre_2fa', 'usuario_pre_2fa']);

        return response()->json([
            'success' => true,
            'mensaje' => '¡Acceso autorizado!',
            'redirect' => '/dashboard'
        ]);
    }


    public function mostrarFormulario2FA($cod_usuario)
    {
        return view('verifica', ['cod_usuario' => $cod_usuario]);
    }


    public function actualizarPasswordPrimerIngreso(Request $request)
    {
        if (!$request->expectsJson()) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Formato de solicitud inválido, se esperaba JSON.'
            ], 406);
        }

        $request->validate([
            'cod_usuario' => 'required|integer',
            'nueva_contrasena' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'confirmar_contrasena' => 'required|same:nueva_contrasena',
            'cod_pregunta1' => 'required|integer|different:cod_pregunta2',
            'respuesta1' => 'required|string|min:2',
            'cod_pregunta2' => 'required|integer|different:cod_pregunta1',
            'respuesta2' => 'required|string|min:2',
        ], [
            'nueva_contrasena.regex' => 'La contraseña debe incluir mayúsculas, minúsculas y números.',
            'cod_pregunta1.different' => 'Las preguntas de recuperación no pueden ser iguales.',
            'cod_pregunta2.different' => 'Las preguntas de recuperación no pueden ser iguales.',
        ]);

        try {
            $data = [
                'cod_usuario' => $request->cod_usuario,
                'nueva_contrasena' => $request->nueva_contrasena,
                'cod_pregunta1' => $request->cod_pregunta1,
                'respuesta1' => $request->respuesta1,
                'cod_pregunta2' => $request->cod_pregunta2,
                'respuesta2' => $request->respuesta2,
            ];

            $response = Http::put('http://localhost:3000/actualizar-contrasena', $data);

            if ($response->successful()) {
                session()->forget('usuario');

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'mensaje' => 'Contraseña y preguntas de recuperación actualizadas correctamente.'
                    ]);
                } else {
                    return redirect()
                        ->route('login')
                        ->with('success', 'Contraseña y preguntas de recuperación actualizadas correctamente. Inicie sesión con sus nuevas credenciales.');
                }
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se pudo actualizar la contraseña y preguntas de recuperación',
                    'error' => $response->json(),
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

    public function mostrarVistaPrimerAcceso()
    {
        try {

            $response = Http::get('http://localhost:3000/preguntas-recuperacion');

            if ($response->successful()) {
                $preguntas = $response->json();

                return view('oneinicio', compact('preguntas'));
            } else {

                return view('oneinicio', ['preguntas' => []])
                    ->with('error', 'No se pudieron cargar las preguntas de recuperación. Intente nuevamente.');
            }
        } catch (\Exception $e) {
            return view('oneinicio', ['preguntas' => []])
                ->with('error', 'Error de conexión al cargar las preguntas de recuperación: ' . $e->getMessage());
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
        return redirect()->route('logn')->with('success', 'Sesión cerrada correctamente');
    }

    public function obtenerPreguntasUsuario(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string'
        ], [
            'usuario.required' => 'Debe ingresar el nombre de usuario para recuperar su contraseña.'
        ]);

        try {
            $response = Http::post('http://localhost:3000/preguntas-usuario', [
                'nombre_usuario' => $request->usuario
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['success']) {
                    return response()->json([
                        'success' => true,
                        'preguntas' => $data['preguntas'],
                        'cod_usuario' => $data['preguntas'][0]['cod_usuario'], // para usar en el modal
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'mensaje' => $data['mensaje']
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se pudo obtener las preguntas de recuperación.',
                    'codigo_http' => $response->status(),
                    'error' => $response->body()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al conectar con el servidor de preguntas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function validarPreguntasYActualizarContrasena(Request $request)
    {
        $data = $request->only([
            'cod_usuario',
            'nueva_contrasena',
            'cod_pregunta1',
            'respuesta1',
            'cod_pregunta2',
            'respuesta2'
        ]);

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('http://localhost:3000/validar-respuestas', $data);

            if ($response->successful()) {
                $json = $response->json();
                return response()->json([
                    'success' => $json['success'] ?? true,
                    'mensaje' => $json['mensaje'] ?? 'Contraseña actualizada correctamente',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Respuestas incorrectas o error del servidor',
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión con el servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}
