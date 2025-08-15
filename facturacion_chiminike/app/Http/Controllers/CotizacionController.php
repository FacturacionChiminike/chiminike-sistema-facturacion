<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cotizacion;
use App\Mail\CotizacionMail;
use Illuminate\Support\Facades\Mail;

class CotizacionController extends Controller
{
    public function index()
    {
        try {
            // Obtener las cotizaciones
            $responseCotizaciones = Http::get('http://localhost:3000/cotizaciones');

            if (!$responseCotizaciones->successful()) {
                return back()->with('error', 'Error al obtener cotizaciones: Respuesta inválida del servidor.');
            }

            $cotizaciones = $responseCotizaciones->json() ?? [];

            // Obtener los catálogos de cotización
            $responseCatalogos = Http::get('http://localhost:3000/catalogos-cotizacion');

            if (!$responseCatalogos->successful()) {
                return back()->with('error', 'Error al obtener catálogos de cotización: Respuesta inválida del servidor.');
            }

            $catalogosData = $responseCatalogos->json();
            $catalogos = $catalogosData['data'] ?? [
                'entradas' => [],
                'paquetes' => [],
                'adicionales' => [],
                'inventario' => [],
                'salones' => []
            ];

            // Obtener horas extra por salón
            $horasExtrasSalon = [];

            foreach ($catalogos['salones'] as $salon) {
                $nombreSalon = urlencode($salon['nombre']);
                $responseHorasExtra = Http::get("http://localhost:3000/horas-extra-salon/{$nombreSalon}");

                if ($responseHorasExtra->successful()) {
                    $horasExtrasSalon[$salon['nombre']] = $responseHorasExtra->json();
                } else {
                    $horasExtrasSalon[$salon['nombre']] = [];
                }
            }

            // Obtener los municipios
            $responseMunicipios = Http::get('http://localhost:3000/municipio.date');

            if (!$responseMunicipios->successful()) {
                return back()->with('error', 'Error al obtener municipios: Respuesta inválida del servidor.');
            }

            $municipios = $responseMunicipios->json() ?? [];

            // Obtener los clientes
            $responseClientes = Http::get('http://localhost:3000/select.cliente');

            if (!$responseClientes->successful()) {
                return back()->with('error', 'Error al obtener clientes: Respuesta inválida del servidor.');
            }

            $clientes = $responseClientes->json() ?? [];

            // Enviar todo a la vista
            return view('cotizaciones', compact(
                'cotizaciones',
                'catalogos',
                'municipios',
                'clientes',
                'horasExtrasSalon'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al obtener datos: ' . $e->getMessage());
        }
    }



    public function store(Request $request)
    {
        try {
            $token = session('token');
            $rules = [
                'cod_cliente' => 'nullable|integer|min:1',
                'evento_nombre' => 'required|string|max:100',
                'fecha_evento' => 'required|date',
                'hora_evento' => 'required',
                'horas_evento' => 'required|integer|min:1',
                'productos' => 'required|array|min:1',
            ];

            // Si NO se selecciona cliente existente, validar campos   de cliente nuevo
            if (!$request->filled('cod_cliente')) {
                $rules = array_merge($rules, [
                    'nombre' => 'required|string|max:100',
                    'fecha_nacimiento' => 'nullable|date',
                    'sexo' => 'required|string|in:Masculino,Femenino,Otro',
                    'dni' => 'required|string|max:20',
                    'correo' => 'required|email',
                    'telefono' => 'required|string|max:20',
                    'direccion' => 'required|string',
                    'cod_municipio' => 'required|integer',
                    'rtn' => 'nullable|string|max:20',
                    'tipo_cliente' => 'required|string|in:Individual,Empresa',
                ]);
            }

            $request->validate($rules);

            $payload = $request->only([
                'cod_cliente',
                'nombre',
                'fecha_nacimiento',
                'sexo',
                'dni',
                'correo',
                'telefono',
                'direccion',
                'cod_municipio',
                'rtn',
                'tipo_cliente',
                'evento_nombre',
                'fecha_evento',
                'hora_evento',
                'horas_evento',
                'productos',
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ])->post("http://localhost:3000/cotizacion.new", $payload);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Error al insertar cotización en el servidor Node.',
                    'detalles' => $response->json()
                ], $response->status());
            }

            $data = $response->json();

            return response()->json([
                'mensaje' => $data['mensaje'] ?? 'Cotización creada correctamente.',
                'cod_cotizacion' => $data['cod_cotizacion'] ?? null
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Datos inválidos',
                'detalles' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error inesperado',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }


     public function enviarCorreo($id)
    {
        try {


            $responseCotizacion = Http::get("http://localhost:3000/cotizaciones.get/{$id}");
            $cotizacionData = $responseCotizacion->json();

            $cotizacion = $cotizacionData['cotizacion'] ?? null;
            $productos = $cotizacionData['productos'] ?? [];

            if (!$cotizacion) {
                return response()->json(['error' => 'No se encontró la cotización.']);
            }


            $responseCorreo = Http::get("http://localhost:3000/correo-cliente/{$id}");
            $correoCliente = $responseCorreo->json()[0]['correo'] ?? null;

            if (!$correoCliente) {
                return response()->json(['error' => 'El cliente no tiene correo registrado.']);
            }


            $pdf = Pdf::loadView('cotizaciones.pdf', [
                'cotizacion' => $cotizacion,
                'productos' => $productos,
            ]);


          // Envío con copia
        Mail::to($correoCliente)
            ->cc('lmolinam2222@gmail.com') // puedes usar ->bcc() si quieres que sea copia oculta
            ->send(new CotizacionMail($cotizacion, $pdf));

            return response()->json(['mensaje' => 'Cotización enviada correctamente al cliente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo: ' . $e->getMessage()]);
        }
    }


      public function detalle($id)
    {
        try {
            $response = Http::timeout(10)->get("http://localhost:3000/cotizaciones.get/{$id}");

            if ($response->failed()) {
                return response()->json([
                    'error' => 'No se pudo conectar con el servidor de API.'
                ], 500);
            }

            $json = $response->json();


            if (!isset($json['cotizacion']) || empty($json['cotizacion'])) {
                return response()->json([
                    'error' => 'Cotización no encontrada o datos incompletos.'
                ], 404);
            }

            $cotizacion = $json['cotizacion'];
            $productos = $json['productos'] ?? [];


            return response()->json([
                'cod_cotizacion' => $cotizacion['cod_cotizacion'] ?? null,
                'fecha' => $cotizacion['fecha'] ?? null,
                'fecha_validez' => $cotizacion['fecha_validez'] ?? null,
                'estado' => $cotizacion['estado'] ?? null,
                'nombre_evento' => $cotizacion['nombre_evento'] ?? null,
                'fecha_programa' => $cotizacion['fecha_programa'] ?? null,
                'hora_programada' => $cotizacion['hora_programada'] ?? null,
                'horas_evento' => $cotizacion['horas_evento'] ?? null,
                'nombre_cliente' => $cotizacion['nombre_cliente'] ?? null,
                'telefono_cliente' => $cotizacion['telefono_cliente'] ?? null,
                'correo_cliente' => $cotizacion['correo_cliente'] ?? null,
                'productos' => $productos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener la cotización: ' . $e->getMessage()
            ], 500);
        }
    }



  public function update(Request $request, $id)
{
    try {
        $request->validate([
            'nombre_evento' => 'required|string|max:100',
            'fecha_programa' => 'required|date',
            'hora_programada' => 'required',
            'horas_evento' => 'required|integer|min:0',
            'estado' => 'required|string',
            'productos' => 'nullable|array',
        ]);

        $data = [
            'nombre_evento'    => $request->nombre_evento,
            'fecha_programa'   => $request->fecha_programa,
            'hora_programada'  => $request->hora_programada,
            'horas_evento'     => $request->horas_evento,
            'estado'           => $request->estado,
            'productos'        => $request->productos ?? []
        ];

        $token = session('token'); 

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ])->put("http://localhost:3000/cotizaciones.upd/{$id}", $data);

        if ($response->failed()) {
            return response()->json([
                'mensaje' => 'No se pudo actualizar la cotización en el servidor de Node.',
                'error'   => $response->body()
            ], $response->status());
        }

        $mensaje = $response->json('mensaje') ?? 'Cotización actualizada correctamente.';
        return response()->json(['mensaje' => $mensaje], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'mensaje' => 'Datos inválidos',
            'errors'  => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'mensaje' => 'Error inesperado: ' . $e->getMessage()
        ], 500);
    }
}


    public function generarPDF($id)
    {
        try {
            //  Consumir API para obtener la cotización
            $response = Http::timeout(10)->get("http://localhost:3000/cotizaciones.get/{$id}");

            if ($response->failed()) {
                return response()->json([
                    'mensaje' => 'No se pudo obtener la cotización.'
                ], 500);
            }

            $data = $response->json();

            if (!isset($data['cotizacion']) || !isset($data['productos'])) {
                return response()->json([
                    'mensaje' => 'Datos incompletos para generar el PDF.'
                ], 400);
            }

            $cotizacion = $data['cotizacion'];
            $productos = $data['productos'];

            //  Generar PDF con la vista pdfcotizacion
            $pdf = Pdf::loadView('pdfcotizacion', compact('cotizacion', 'productos'))
                ->setPaper('letter');

            //  Nombre de archivo limpio
            $nombreArchivo = 'cotizacion_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $cotizacion['nombre_evento']) . '_' . now()->format('Ymd_His') . '.pdf';

            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "attachment; filename=\"{$nombreArchivo}\"");
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al generar el PDF: ' . $e->getMessage()
            ], 500);
        }
    }

   public function destroy($id)
{
    try {
        $token = session('token'); 

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete("http://localhost:3000/cotizacion/{$id}");

        if ($response->failed()) {
            return response()->json([
                'ok' => false,
                'mensaje' => 'Error al eliminar la cotización desde la API.'
            ], 500);
        }

        $mensaje = $response->json()['mensaje'] ?? 'Cotización eliminada correctamente.';

        return response()->json([
            'ok' => true,
            'mensaje' => $mensaje
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'ok' => false,
            'mensaje' => 'Error al eliminar la cotización: ' . $e->getMessage()
        ], 500);
    }
}

}
