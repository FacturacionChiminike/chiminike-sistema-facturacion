<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReservacionMail;
use Illuminate\Support\Facades\Mail;

class ReservacionesController extends Controller
{
    /**
     * Mostrar todas las reservaciones confirmadas
     */
    public function index()
    {
        try {
            // 🟩 Obtener las reservaciones
            $responseReservaciones = Http::get('http://localhost:3000/reservaciones');

            if (!$responseReservaciones->successful()) {
                return back()->with('error', 'Error al obtener reservaciones: Respuesta inválida del servidor.');
            }

            $reservaciones = $responseReservaciones->json() ?? [];

            // 🟩 Obtener los catálogos de cotización
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

            // 🟩 Retornar la vista con reservaciones y catálogos
            return view('reservaciones', compact('reservaciones', 'catalogos'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al obtener datos: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $response = Http::timeout(10)->get("http://localhost:3000/reservaciones.get/{$id}");

            if ($response->failed()) {
                return response()->json([
                    'mensaje' => 'No se pudo conectar con el servidor de API.'
                ], 500);
            }

            $data = $response->json();

            if (!isset($data['evento']) || !isset($data['productos']) || empty($data['evento'])) {
                return response()->json([
                    'mensaje' => 'Reservación no encontrada o datos incompletos.'
                ], 404);
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la reservación: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generarPDF($id)
    {
        try {
            $response = Http::timeout(10)->get("http://localhost:3000/reservaciones.get/{$id}");

            if ($response->failed()) {
                return response()->json([
                    'mensaje' => 'No se pudo obtener la reservación.'
                ], 500);
            }

            $data = $response->json();

            if (!isset($data['evento']) || !isset($data['productos'])) {
                return response()->json([
                    'mensaje' => 'Datos incompletos para generar el PDF.'
                ], 400);
            }

            $evento = $data['evento'];
            $productos = $data['productos'];

            $pdf = Pdf::loadView('pdfreserva', compact('evento', 'productos'))
                ->setPaper('letter');

            $nombreArchivo = 'reservacion_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $evento['nombre_evento']) . '_' . now()->format('Ymd_His') . '.pdf';

            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "attachment; filename=\"{$nombreArchivo}\"");
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al generar el PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // ✅ Validar campos requeridos
            $request->validate([
                'nombre_evento' => 'required|string|max:100',
                'fecha_programa' => 'required|date',
                'hora_programada' => 'required',
                'horas_evento' => 'required|integer|min:0',
                'productos' => 'nullable|array',
            ]);

            // ✅ Preparar datos a enviar
            $data = [
                'nombre_evento' => $request->nombre_evento,
                'fecha_programa' => $request->fecha_programa,
                'hora_programada' => $request->hora_programada,
                'horas_evento' => $request->horas_evento,
                'productos' => $request->productos ?? []
            ];


            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->put("http://localhost:3000/cotizaciones.upd/{$id}", $data);


            if ($response->failed()) {
                return response()->json([
                    'mensaje' => 'No se pudo actualizar la cotización en el servidor de Node.',
                    'error' => $response->body()
                ], $response->status());
            }
            


            $resData = $response->json();
            $mensaje = $resData['mensaje'] ?? 'Cotización actualizada correctamente.';


            return response()->json(['mensaje' => $mensaje], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'mensaje' => 'Datos inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function enviarCorreoReservacion($id)
    {
        try {
            // Obtener datos de la reservación
            $responseReservacion = Http::get("http://localhost:3000/reservaciones.get/{$id}");
            $reservacionData = $responseReservacion->json();

            $reservacion = $reservacionData['evento'] ?? null;
            $productos = $reservacionData['productos'] ?? [];

            if (!$reservacion) {
                return response()->json(['error' => 'No se encontró la reservación.']);
            }

            // Obtener el correo del cliente usando el cod_evento
            $responseCorreo = Http::get("http://localhost:3000/correo-cliente/{$id}");
            $correoCliente = $responseCorreo->json()[0]['correo'] ?? null;

            if (!$correoCliente) {
                return response()->json(['error' => 'El cliente no tiene correo registrado.']);
            }

            // Generar el PDF
            $pdf = Pdf::loadView('reservaciones.pdf', [
                'reservacion' => $reservacion,
                'productos' => $productos,
            ]);

            // Enviar el correo
        
             Mail::to($correoCliente)
            ->cc('lmolinam2222@gmail.com') // puedes usar ->bcc() si quieres que sea copia oculta
            ->send(new ReservacionMail($reservacion, $pdf));


            return response()->json(['mensaje' => 'Reservación enviada correctamente al cliente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo: ' . $e->getMessage()]);
        }
    }
}
