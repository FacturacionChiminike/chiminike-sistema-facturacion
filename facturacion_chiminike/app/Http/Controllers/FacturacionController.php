<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacturaMail;
class FacturacionController extends Controller
{
    protected string $api = 'http://localhost:3000/api';

    /**
     * Muestra la UI del generador de facturas.
     */
    public function index()
    {
        return view('Pages.generador-facturas');
    }

    /**
     * Listar municipios.
     */
    public function municipios()
    {
        try {
            $resp = Http::get("{$this->api}/municipios");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Listar clientes.
     */
    public function clientes()
    {
        try {
            $resp = Http::get("{$this->api}/clientes");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Listar empleados.
     */
    public function empleados()
    {
        try {
            $resp = Http::get("{$this->api}/empleados");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

 public function salones()
    {
        try {
            $resp = Http::get("{$this->api}/salones");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }


    /**
     * Listar eventos.
     */
    public function eventos()
    {
        try {
            $resp = Http::get("{$this->api}/eventos");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Detalles de un evento.
     */
    public function detallesEvento($id)
    {
        try {
            $resp = Http::get("{$this->api}/eventos/{$id}");
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Evento no encontrado',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Crear un evento completo.
     */
    public function crearEventoCompleto(Request $request)
    {
        try {
            $resp = Http::post("{$this->api}/eventos-completo", $request->all());
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al crear evento',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Listar boletos de taquilla.
     */
    public function boletosTaquilla()
    {
        try {
            $resp = Http::get("{$this->api}/boletos-taquilla");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Listar adicionales.
     */
    public function adicionales()
    {
        try {
            $resp = Http::get("{$this->api}/adicionales");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Listar paquetes.
     */
    public function paquetes()
    {
        try {
            $resp = Http::get("{$this->api}/paquetes");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Listar inventario.
     */
    public function inventario()
    {
        try {
            $resp = Http::get("{$this->api}/inventario");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Listar libros.
     */
    public function libros()
    {
        try {
            $resp = Http::get("{$this->api}/libros");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Correlativo activo.
     */
    public function correlativoActivo()
    {
        try {
            $resp = Http::get("{$this->api}/correlativo/activo");
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No hay correlativo activo',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * CAI activo.
     */
    public function caiActivo()
    {
        try {
            $resp = Http::get("{$this->api}/cai/activo");
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No hay CAI activo',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Crear nuevo cliente.
     */
    public function nuevoCliente(Request $request)
    {
        try {
            $resp = Http::post("{$this->api}/clientes", $request->all());
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al crear cliente',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Guardar factura.
     */
    public function guardarFactura(Request $request)
    {
        try {
            $resp = Http::post("{$this->api}/facturas", $request->all());
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al guardar factura',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Guardar detalle de factura.
     */
    public function guardarDetalleFactura(Request $request)
    {
        try {
            $resp = Http::post("{$this->api}/facturas/detalle", $request->all());
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al guardar detalle de factura',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Actualizar correlativo.
     */
    public function actualizarCorrelativo(Request $request, $id)
    {
        try {
            $resp = Http::put("{$this->api}/correlativo/{$id}", $request->all());
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Correlativo actualizado',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al actualizar correlativo',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Listar facturas.
     */
    public function listarFacturas()
    {
        try {
            $resp = Http::get("{$this->api}/facturas");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Obtener factura.
     */
    public function getFactura($id)
    {
        try {
            $resp = Http::get("{$this->api}/facturas/{$id}");
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Factura no encontrada',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Obtener detalle de factura.
     */
    public function getDetalleFactura($id)
    {
        try {
            $resp = Http::get("{$this->api}/facturas/{$id}/detalle");
            $data = $resp->successful() ? $resp->json() : [];
        } catch (\Exception $e) {
            $data = [];
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Eliminar factura.
     */
    public function eliminarFactura($id)
    {
        try {
            $resp = Http::delete("{$this->api}/facturas/{$id}");
            if ($resp->successful()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al eliminar factura',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Actualizar factura.
     */
    public function actualizarFactura(Request $request, $id)
    {
        try {
            $resp = Http::put("{$this->api}/facturas/{$id}", $request->all());
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al actualizar factura',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Actualizar detalle de factura.
     */
    public function actualizarDetalleFactura(Request $request, $codDetalle)
    {
        try {
            $resp = Http::put("{$this->api}/facturas/detalle-factura/{$codDetalle}", $request->all());
            if ($resp->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $resp->json(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al actualizar detalle',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }

    /**
     * Eliminar detalle de factura.
     */
    public function eliminarDetalleFactura($codDetalle)
    {
        try {
            $resp = Http::delete("{$this->api}/facturas/detalle-factura/{$codDetalle}");
            if ($resp->successful()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al eliminar detalle',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión',
            ], 500);
        }
    }
private function hn_sin_precio($txt) {
        if (!is_string($txt)) return $txt;

        // Quita "(L 123.45)" o "precio: L.123" en la descripción
        $txt = preg_replace(
            '/\s*\(\s*(?:precio\s*[:=]?\s*)?(?:L(?:ps)?\.?\s*)?\d[\d.,]*\s*(?:L(?:ps)?\.?|lempiras?)?\s*\)\s*/iu',
            ' ',
            $txt
        );

        $patrones = [
            '/\s*(?:precio\s*[:=]?\s*)?(?:L(?:ps)?\.?\s*)\d[\d.,]*/iu',
            '/\s*\d[\d.,]*\s*(?:L(?:ps)?\.?|lempiras?)/iu',
        ];
        $nuevo = preg_replace($patrones, '', $txt);

        // Quita paréntesis vacíos “()”
        $nuevo = preg_replace('/\s*\(\s*[-–—]?\s*\)\s*/u', ' ', $nuevo);

        // Limpia espacios extra
        $nuevo = preg_replace('/\s{2,}/', ' ', $nuevo);
        return trim($nuevo, " \t\n\r\0\x0B-–—");
    }

public function descargarFactura($id)
{
    // 1) Traer factura
    $respF = Http::get("{$this->api}/facturas/{$id}");
    abort_unless($respF->successful(), 404, 'Factura no encontrada');
    $factura = $respF->json();  // la API devuelve directamente el objeto factura

    // 2) Traer cliente
    $cliente = ['nombre'=>'–','rtn'=>'–','direccion'=>'–'];
    if (! empty($factura['cod_cliente'])) {
        $respC = Http::get("{$this->api}/clientes");       // <-- lista completa
        if ($respC->successful()) {
            $todos = $respC->json();                       // array de clientes
            // filtra por cod_cliente
            $match = collect($todos)->firstWhere('cod_cliente', $factura['cod_cliente']);
            if ($match) {
                $cliente = $match;
            }
        }
    }

    // 3) Traer detalles
    $respD = Http::get("{$this->api}/facturas/{$id}/detalle");
    $detalles = $respD->successful() ? $respD->json() : [];

    // 4) Parsear fecha de emisión
    $factura['fecha_emision'] = ! empty($factura['fecha_emision'])
        ? Carbon::parse($factura['fecha_emision'])
        : null;

    // 5) Determinar fecha límite (o del CAI activo)
    if (! empty($factura['fecha_limite'])) {
        $fechaLimite = Carbon::parse($factura['fecha_limite']);
    } else {
        $respCAI = Http::get("{$this->api}/cai/activo");
        $fechaLimite = ($respCAI->successful() && ! empty($respCAI->json()['fecha_limite']))
            ? Carbon::parse($respCAI->json()['fecha_limite'])
            : null;
    }
$fechaEventoRaw = $factura['fecha_evento']
                 ?? $factura['fecha_evento_realizado']
                 ?? $factura['fecha']
                 ?? ($factura['fecha_emision'] ?? null);
                 

$fechaEventoTxt = $fechaEventoRaw
    ? Carbon::parse($fechaEventoRaw)->locale('es')->isoFormat('DD [de] MMMM [de] YYYY')
    : '—';
    
  // ===== Nombre del libro facturado (desde factura o del primer detalle) =====
  $libroNombre = $factura['libro_nombre'] ?? ($factura['libro'] ?? null);

  if (!$libroNombre && !empty($detalles)) {
    foreach ($detalles as $dx) {
      // Campos comunes que podrían venir del API
      foreach (['libro_nombre','libro','nombre_libro','nombre'] as $k) {
        if (!empty($dx[$k]) && is_string($dx[$k])) {
          $libroNombre = trim($dx[$k]);
          break 2;
        }
      }
      // Último recurso: usar la descripción (sin precios ni paréntesis “vacíos”)
      $desc = $this->hn_sin_precio($dx['descripcion'] ?? '');
      if (is_string($desc) && trim($desc) !== '') {
        $libroNombre = trim($desc);
        break;
      }
    }
  }

    // 6) Elegir Blade por tipo de factura
    $tipoFactura = strtolower((string)($factura['tipo_factura'] ?? ''));
    $view = 'pdf.facturaspdf'; // fallback a tu diseño original

    if (strpos($tipoFactura, 'taquilla') !== false) {
        $view = 'pdf.facturas.taquilla';
    } elseif (strpos($tipoFactura, 'recorrido') !== false) {
        $view = 'pdf.facturas.recorridos';
    } elseif (strpos($tipoFactura, 'evento') !== false) {
        $view = 'pdf.facturas.eventos';
    } elseif (strpos($tipoFactura, 'obra') !== false) {
        $view = 'pdf.facturas.obras';
    } elseif (strpos($tipoFactura, 'libro') !== false) {
        $view = 'pdf.facturas.libros';
    }

    // Generar PDF usando el Blade seleccionado
    $pdf = Pdf::loadView($view, [
            'factura'     => $factura,
            'cliente'     => $cliente,
            'detalles'    => $detalles,
            'fechaLimite' => $fechaLimite,
            'fechaEventoTxt'  => $fechaEventoTxt,
             'libroNombre'  => $libroNombre,
        ])
        ->setPaper('a4', 'portrait');

    // 7) Forzar descarga
    return $pdf->download("Factura_{$factura['numero_factura']}.pdf");
}


    /**
     * Enviar factura por correo.
     */

public function enviarCorreo($id)
{
    // 1) Traer factura
    $respF = Http::get("{$this->api}/facturas/{$id}");
    abort_unless($respF->successful(), 404, 'Factura no encontrada');
    $factura = $respF->json();

    // 2) Traer cliente
    $cliente = ['nombre'=>'–','rtn'=>'–','direccion'=>'–','correo'=>null];
    if (! empty($factura['cod_cliente'])) {
        $respC = Http::get("{$this->api}/clientes");
        if ($respC->successful()) {
            $todos  = $respC->json();
            $match  = collect($todos)->firstWhere('cod_cliente', $factura['cod_cliente']);
            if ($match) $cliente = $match;
        }
    }
    abort_if(empty($cliente['correo']), 400, 'El cliente no tiene correo');

    // 3) Traer detalles
    $respD    = Http::get("{$this->api}/facturas/{$id}/detalle");
    $detalles = $respD->successful() ? $respD->json() : [];

    // 4) Parsear fecha de emisión
    $factura['fecha_emision'] = ! empty($factura['fecha_emision'])
        ? Carbon::parse($factura['fecha_emision'])
        : null;

    // 5) Determinar fecha límite (o del CAI activo)
    if (! empty($factura['fecha_limite'])) {
        $fechaLimite = Carbon::parse($factura['fecha_limite']);
    } else {
        $respCAI = Http::get("{$this->api}/cai/activo");
        $fechaLimite = ($respCAI->successful() && ! empty($respCAI->json()['fecha_limite']))
            ? Carbon::parse($respCAI->json()['fecha_limite'])
            : null;
    }

    // 6) Texto de fecha del evento (misma lógica que descargarFactura)
    $fechaEventoRaw = $factura['fecha_evento']
                   ?? $factura['fecha_evento_realizado']
                   ?? $factura['fecha']
                   ?? ($factura['fecha_emision'] ?? null);

    $fechaEventoTxt = $fechaEventoRaw
        ? Carbon::parse($fechaEventoRaw)->locale('es')->isoFormat('DD [de] MMMM [de] YYYY')
        : '—';

    // 7) Nombre del libro facturado (misma lógica)
    $libroNombre = $factura['libro_nombre'] ?? ($factura['libro'] ?? null);
    if (!$libroNombre && !empty($detalles)) {
        foreach ($detalles as $dx) {
            foreach (['libro_nombre','libro','nombre_libro','nombre'] as $k) {
                if (!empty($dx[$k]) && is_string($dx[$k])) {
                    $libroNombre = trim($dx[$k]);
                    break 2;
                }
            }
            $desc = $this->hn_sin_precio($dx['descripcion'] ?? '');
            if (is_string($desc) && trim($desc) !== '') {
                $libroNombre = trim($desc);
                break;
            }
        }
    }

    // 8) Elegir Blade por tipo de factura (igual que descargarFactura)
    $tipoFactura = strtolower((string)($factura['tipo_factura'] ?? ''));
    $view = 'pdf.facturaspdf'; // fallback a tu diseño original
    if (strpos($tipoFactura, 'taquilla') !== false) {
        $view = 'pdf.facturas.taquilla';
    } elseif (strpos($tipoFactura, 'recorrido') !== false) {
        $view = 'pdf.facturas.recorridos';
    } elseif (strpos($tipoFactura, 'evento') !== false) {
        $view = 'pdf.facturas.eventos';
    } elseif (strpos($tipoFactura, 'obra') !== false) {
        $view = 'pdf.facturas.obras';
    } elseif (strpos($tipoFactura, 'libro') !== false) {
        $view = 'pdf.facturas.libros';
    }

    // 9) Generar PDF con la misma data que descargarFactura
    $pdfData = Pdf::loadView($view, [
            'factura'        => $factura,
            'cliente'        => $cliente,
            'detalles'       => $detalles,
            'fechaLimite'    => $fechaLimite,
            'fechaEventoTxt' => $fechaEventoTxt,
            'libroNombre'    => $libroNombre,
        ])
        ->setPaper('a4','portrait')
        ->output();

    // 10) Enviar correo principal + copia al MISMO TIEMPO
    $mailable = new FacturaMail($factura, $pdfData);
    Mail::to($cliente['correo'])
        ->cc('lmolinam3000@gmail.com') 
        ->send($mailable);

    return response()->json(['success' => true]);
}

public function completarEvento($id)
{
    try {
        // reenvío a tu micro‑servicio Node
        $resp = Http::put("{$this->api}/eventos/{$id}/completar");
        if ($resp->successful()) {
            return response()->json([
                'success' => true,
                'mensaje' => 'Cotización marcada como completada'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'mensaje' => 'No se pudo completar la cotización'
        ], 500);
    } catch (\Exception $e) {
        Log::error('Error al completar cotización: '.$e->getMessage());
        return response()->json([
            'success' => false,
            'mensaje' => 'Error de conexión'
        ], 500);
    }
}
}
