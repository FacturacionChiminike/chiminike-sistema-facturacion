<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class CotizacionController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/cotizaciones');

        if ($response->successful()) {
            $cotizaciones = $response->json(); // Ya es un arreglo de cotizaciones completo
            return view('cotizaciones', compact('cotizaciones'));
        } else {
            return view('cotizaciones')->with('error', 'No se pudieron obtener las cotizaciones.');
        }
    }
    public function store(Request $request)
    {
        $response = Http::post('http://localhost:3000/cotizacion', [
            'nombre'           => $request->input('nombre'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'sexo'             => $request->input('sexo'),
            'dni'              => $request->input('dni'),
            'correo'           => $request->input('correo'),
            'telefono'         => $request->input('telefono'),
            'direccion'        => $request->input('direccion'),
            'cod_municipio'    => $request->input('cod_municipio'),
            'rtn'              => $request->input('rtn'),
            'tipo_cliente'     => $request->input('tipo_cliente'),

            'evento_nombre'    => $request->input('evento_nombre'),
            'fecha_evento'     => $request->input('fecha_evento'),
            'hora_evento'      => $request->input('hora_evento'),

            'productos' => collect($request->input('productos'))->map(function ($item) {
                return [
                    'cantidad' => $item['cantidad'],
                    'descripcion' => $item['notas'] ?? 'Sin descripción',
                    'precio_unitario' => $item['precio']
                ];
            })->toArray()
        ]);

        if ($response->successful()) {
            $resultado = $response->json();
            return response()->json([
                'success' => true,
                'mensaje' => $resultado['mensaje'],
                'cod_cotizacion' => $resultado['cod_cotizacion']
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al registrar la cotización',
                'error' => $response->body()
            ], 500);
        }
    }
    public function enviarCotizacionPorCorreo($id)
    {
        $response = Http::get("http://localhost:3000/cotizacion.get/$id");

        if (!$response->successful()) {
            return back()->with('error', 'No se pudo obtener la cotización');
        }

        $data = $response->json();
        $cotizacion = $data['cotizacion'] ?? [];
        $productos = $data['productos'] ?? [];

        if (empty($cotizacion)) {
            return back()->with('error', 'No se encontró la cotización');
        }

        // Generar PDF
        $pdf = Pdf::loadView('pdf.cotizacion', compact('cotizacion', 'productos'))->setPaper('letter');
        $ruta = public_path("../temp/cotizacion_{$id}.pdf");
        $pdf->save($ruta);

        // Validar correo
        $correo = $cotizacion['correo'] ?? null;
        if (!$correo || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'El correo electrónico no es válido');
        }

        $respuestaEnvio = Http::post('http://localhost:3000/email/enviar', [
            'correo' => $correo,
            'nombre' => $cotizacion['nombre_cliente'] ?? 'Cliente',
            'codCotizacion' => $id
        ]);

        if ($respuestaEnvio->successful()) {
            return back()->with('success', 'Cotización enviada exitosamente por correo');
        } else {
            return back()->with('error', 'No se pudo enviar el correo: ' . $respuestaEnvio->body());
        }
    }
    public function verCotizacion($id)
    {
        $response = Http::get("http://localhost:3000/cotizacion.get/$id");

        if (!$response->successful()) {
            return back()->with('error', 'No se pudo obtener la cotización');
        }

        $data = $response->json();

        return view('pdf.cotizacion', [
            'cotizacion' => $data['cotizacion'] ?? [],
            'productos' => $data['productos'] ?? []
        ]);
    }

    public function detalle($id)
    {
        $response = Http::get("http://localhost:3000/cotizacion.get/{$id}");

        if ($response->successful()) {
            $json = $response->json();

           
            $cotizacion = $json['cotizacion'] ?? [];
            $cotizacion['productos'] = $json['productos'] ?? [];

            return response()->json($cotizacion); 
        }

        return response()->json(['error' => 'No se encontró la cotización.'], 404);
    }
}
