<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ReportesController extends Controller
{
    protected $baseApi;

    public function __construct()
    {
        $this->baseApi = env('API_URL', 'http://localhost:3000/api');
    }

    public function ventasMensuales(Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        if (!$desde || !$hasta) {
            return response()->json(['error' => 'Fechas requeridas: desde y hasta'], 400);
        }

        try {
            $response = Http::get("{$this->baseApi}/reportes/ventas-mensuales", [
                'desde' => $desde,
                'hasta' => $hasta
            ]);
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener ventas mensuales'], 500);
        }
    }

    public function topClientesApi()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/top-clientes");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function serviciosPopulares()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/servicios-populares");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ingresosPorTipo()
    {
        try {
            $response = Http::timeout(30)->get("{$this->baseApi}/reportes/ingresos-por-tipo");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function vistaReportes()
    {
        return view('Pages.reporte');
    }

    public function resumenGeneral()
    {
        try {
            $response = Http::retry(3, 100)->get("{$this->baseApi}/reportes/resumen-general");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cotizaciones()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/cotizaciones");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener cotizaciones'], 500);
        }
    }

    public function entradas()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/entradas");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar entradas'], 500);
        }
    }

    public function inventario()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/inventario");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar inventario'], 500);
        }
    }

    public function resumenPorTipoFactura()
    {
        try {
             $response = Http::get("{$this->baseApi}/reportes/facturas/resumen-por-tipo-factura");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener resumen por tipo de factura'], 500);
        }
    }

    public function totalClientes()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/total-clientes");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener total de clientes'], 500);
        }
    }
   

     // llama a total empleado 
       public function totalEmpleados()
{
    try {
        $response = Http::get("{$this->baseApi}/reportes/total-empleados");
        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener total de empleados'], 500);
    }
}


    public function eventos()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/eventos");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener eventos'], 500);
        }
    }

    public function totalEventos()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/total-eventos");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener total de eventos'], 500);
        }
    }

    public function clientes()
    {
        try {
            $response = Http::get("{$this->baseApi}/reportes/clientes");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener clientes'], 500);
        }
    }

    public function empleados()
{
    try {
        $response = Http::get("{$this->baseApi}/reportes/empleados");
        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener reporte de empleados'], 500);
    }
}

// llama a las ventas de lunes a viernes 
public function ventasLunesViernes()
{
    try {
        $consulta = DB::select("CALL sp_ventas_lunes_a_viernes()");
        return response()->json($consulta);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener ventas de lunes a viernes: ' . $e->getMessage()], 500);
    }
}

// llama a la ventas de sabado y domingo :0z
public function ventasChiminikeWeekend()
{
    try {
        $result = DB::select("CALL sp_ventas_chiminike_weekend()");
        return response()->json($result);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

// total de cotizaciones 
public function totalCotizaciones()
{
    try {
        $resultado = DB::select("CALL sp_total_cotizaciones()");
        return response()->json($resultado[0]); // Solo la fila principal
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

//llama a los reportes reservaciones 
public function reservaciones()
{
    try {
        $response = Http::get("{$this->baseApi}/reportes/reporte-reservaciones");
        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al obtener reservaciones',
            'detalle' => $e->getMessage()
        ], 500);
    }
}


// Total de reservaciones
public function totalReservaciones()
{
    try {
        $response = Http::get("{$this->baseApi}/reportes/total-reservaciones");
        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener total de reservaciones'], 500);
    }
}


public function salonesEstado()
{
    try {
        $response = Http::get("{$this->baseApi}/reportes/salones-estado");
        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener estado de salones'], 500);
    }
}


 
public function exportarExcel()
{
    // Fechas fijas para el reporte de ventas mensuales
    $desde = '2025-01-01';
    $hasta = now()->format('Y-m-d');

    // Llamadas a los procedimientos almacenados
    $ventasMensuales   = DB::select("CALL sp_reporte_ventas_mensuales(?, ?)", [$desde, $hasta]);
    $topClientes       = DB::select("CALL sp_reporte_top_clientes()");
    $serviciosPopulares = DB::select("CALL sp_reporte_servicios_populares()");
    $ingresosPorTipo   = DB::select("CALL sp_reporte_ingresos_por_tipo()");
    $resumenPorTipo    = DB::select("CALL sp_reporte_resumen_por_tipo_factura()");
    $cotizaciones      = DB::select("CALL sp_reporte_cotizaciones()");
    $entradas          = DB::select("CALL sp_reporte_entradas()");
    $reservaciones     = DB::select("CALL sp_reporte_reservaciones()");
    $inventario        = DB::select("CALL sp_reporte_inventario()");
    $empleados         = DB::select("CALL sp_reporte_empleados_detallado()");

    // Verifica si hay imagen de gráfico generada en la sesión
    $nombreArchivoGrafico = session('grafico_pdf');
    $rutaImagen = $nombreArchivoGrafico ? storage_path('app/public/' . $nombreArchivoGrafico) : null;
    $graficoBase64 = null;

    if ($rutaImagen && file_exists($rutaImagen)) {
        $graficoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($rutaImagen));
    }

    $fecha = now()->format('Y-m-d_H-i-s');
    $nombreArchivo = "reporte_general_$fecha.xls";

    return response()->view('pdf.excel-resumen', compact(
        'ventasMensuales',
        'topClientes',
        'serviciosPopulares',
        'ingresosPorTipo',
        'resumenPorTipo',
        'cotizaciones',
        'entradas',
        'reservaciones',
        'inventario',
        'empleados',
        'graficoBase64'
    ))
    ->header('Content-Type', 'application/vnd.ms-excel')
    ->header("Content-Disposition", "attachment; filename=$nombreArchivo");
}
public function generarFacturasPDF()
  {
        // 1) Definir rango de fechas
        $desde = '2025-01-01';
        $hasta = now()->format('Y-m-d');

        // 2) Llamar a cada SP para obtener los datos
        $ventasMensuales    = DB::select("CALL sp_reporte_ventas_mensuales(?, ?)", [$desde, $hasta]);
        $topClientes        = DB::select("CALL sp_reporte_top_clientes()");
        $serviciosPopulares = DB::select("CALL sp_reporte_servicios_populares()");
        $ingresosPorTipo    = DB::select("CALL sp_reporte_ingresos_por_tipo()");
        $resumenPorTipo     = DB::select("CALL sp_reporte_resumen_por_tipo_factura()");
        $facturasPorDia     = DB::select("CALL sp_reporte_facturas_por_dia(?, ?)", [$desde, $hasta]);
        $facturasPorCliente = DB::select("CALL sp_reporte_facturas_por_cliente()");

        // 3) Normalizar a arrays asociativos según campos que tu Blade espera
        $ventasMensuales    = $this->normalizarDatos($ventasMensuales,    ['mes','total_ventas']);
        $topClientes        = $this->normalizarDatos($topClientes,        ['cliente','rtn','total_facturado']);
        $serviciosPopulares = $this->normalizarDatos($serviciosPopulares, ['descripcion','cantidad','ingresos']);
        $ingresosPorTipo    = $this->normalizarDatos($ingresosPorTipo,    ['tipo','ingresos']);
        $resumenPorTipo     = $this->normalizarDatos($resumenPorTipo,     ['tipo_factura','cantidad','total']);
        $facturasPorDia     = $this->normalizarDatos($facturasPorDia,     ['dia','cantidad_facturas','total_facturado']);
        $facturasPorCliente = $this->normalizarDatos($facturasPorCliente, ['cliente','rtn','cantidad_facturas','total_facturado']);

        // 4) Cargar gráfico en Base64 si existe (opcional)
        $graficoBase64 = null;
        if ($archivo = session('grafico_pdf')) {
            $ruta = storage_path("app/public/{$archivo}");
            if (file_exists($ruta)) {
                $graficoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($ruta));
            }
        }

        // 5) Preparar datos para la vista Blade
        $data = [
            'ventasMensuales'    => $ventasMensuales,
            'topClientes'        => $topClientes,
            'serviciosPopulares' => $serviciosPopulares,
            'ingresosPorTipo'    => $ingresosPorTipo,
            'resumenPorTipo'     => $resumenPorTipo,
            'facturasPorDia'     => $facturasPorDia,
            'facturasPorCliente' => $facturasPorCliente,
            'graficoBase64'      => $graficoBase64,
            'fechaGeneracion'    => now()->format('d/m/Y H:i'),
        ];

        // 6) Renderizar PDF usando tu Blade y descargarlo
        return PDF::loadView('pdf.facturas', $data)
                  ->setPaper('a4', 'portrait')
                  ->download('resumen-facturacion.pdf');
    }

    public function generarCotizacionesPDF()
   {
        $cotizaciones      = DB::select("CALL sp_reporte_cotizaciones()");
        $entradas          = DB::select("CALL sp_reporte_entradas()");
        $reservaciones     = DB::select("CALL sp_reporte_reservaciones()");
        $salonesPorEstado  = DB::select("CALL sp_reporte_salones_estado()");

        $cotizaciones     = $this->normalizarDatos($cotizaciones, ['cod_cotizacion','cliente','rtn','fecha','fecha_validez','estado','total_cotizacion']);
        $entradas         = $this->normalizarDatos($entradas, ['cod_entrada','descripcion','total']);
        $reservaciones    = $this->normalizarDatos($reservaciones, ['nombre_evento','fecha_programa','hora_programada','horas_evento','cliente','rtn']);
        $salonesPorEstado = $this->normalizarDatos($salonesPorEstado, ['estado','cantidad']);

       return PDF::loadView('pdf.cotizaciones', compact(
            'cotizaciones',
            'entradas',
            'reservaciones',
            'salonesPorEstado'
        ))->setPaper('a4','portrait')
          ->download('eventos.pdf');
    }
    public function generarEntradasPDF()
    {
        $entradas = DB::select("CALL sp_reporte_entradas()");
        return PDF::loadView('pdf.entradas', compact('entradas'))
                  ->download('reporte_entradas_'.now()->format('Ymd').'.pdf');
    }

    public function generarInventarioPDF()
      {
           $salonesPorEstado  = DB::select("CALL sp_reporte_salones_estado()");
        $inventario = DB::select("CALL sp_reporte_inventario()");
        $inventario = $this->normalizarDatos($inventario, ['cod_inventario','nombre','descripcion','precio_unitario','cantidad_disponible','estado']);
   $salonesPorEstado = $this->normalizarDatos($salonesPorEstado, ['estado','cantidad']);
        return PDF::loadView('pdf.inventario', compact('inventario', 'salonesPorEstado'))
                  ->setPaper('a4','portrait')
                  ->download('inventario.pdf');
    }

    public function generarReservacionesPDF()
    {
        $reservaciones = DB::select("CALL sp_reporte_reservaciones()");
        return PDF::loadView('pdf.reservaciones', compact('reservaciones'))
                  ->download('reporte_reservaciones_'.now()->format('Ymd').'.pdf');
    }

    public function generarEmpleadosPDF()
   {
    // Consulta los empleados
    $empleados = DB::select("CALL sp_reporte_empleados_detallado()");
    // Normaliza igual que antes (si lo necesitas, si no, quítalo)
    $empleados = $this->normalizarDatos($empleados, [
        'cod_empleado','nombre_empleado','dni','cargo','salario','fecha_contratacion',
        'departamento_empresa','region_departamento','telefono','correo','usuario','rol','estado_usuario'
    ]);

    // Consulta los clientes
    $clientes = DB::select("CALL sp_reporte_clientes()");

    // Puedes normalizar clientes si quieres, igual que empleados, o dejarlo así si te sirve directo.
    // Si tus clientes son stdClass y prefieres array, normalízalo así (opcional):
    // $clientes = $this->normalizarDatos($clientes, [
    //    'cliente','rtn','tipo_cliente','dni','sexo','fecha_nacimiento'
    // ]);
    

    return PDF::loadView('pdf.empleados', compact('empleados', 'clientes'))
              ->setPaper('a4', 'landscape')
              ->download('reporte_personas_' . now()->format('Ymd') . '.pdf');
}

    public function generarSalonesEstadoPDF()
    {
        $salones = DB::select("CALL sp_reporte_salones_estado()");
        return PDF::loadView('pdf.salones', compact('salones'))
                  ->download('reporte_salones_'.now()->format('Ymd').'.pdf');
    }

    public function generarEventosPDF()
    {
        $eventos = DB::select("CALL sp_reporte_eventos()");
        return PDF::loadView('pdf.eventos', compact('eventos'))
                  ->download('reporte_eventos_'.now()->format('Ymd').'.pdf');
    }

    public function generarClientesPDF()
    {
        $clientes = DB::select("CALL sp_reporte_clientes()");
        return PDF::loadView('pdf.clientes', compact('clientes'))
                  ->download('reporte_clientes_'.now()->format('Ymd').'.pdf');
    }

public function generarResumenPDF()
{
    $desde = '2025-01-01';
    $hasta = now()->format('Y-m-d');

    // Llamadas a los procedimientos almacenados
    $ventasMensuales     = DB::select("CALL sp_reporte_ventas_mensuales(?, ?)", [$desde, $hasta]);
    $topClientes         = DB::select("CALL sp_reporte_top_clientes()");
    $serviciosPopulares  = DB::select("CALL sp_reporte_servicios_populares()");
    $ingresosPorTipo     = DB::select("CALL sp_reporte_ingresos_por_tipo()");
    $resumenPorTipo      = DB::select("CALL sp_reporte_resumen_por_tipo_factura()");
    $cotizaciones        = DB::select("CALL sp_reporte_cotizaciones()");
    $entradas            = DB::select("CALL sp_reporte_entradas()");
    $reservaciones       = DB::select("CALL sp_reporte_reservaciones()");
    $inventario          = DB::select("CALL sp_reporte_inventario()");
    $empleados           = DB::select("CALL sp_reporte_empleados_detallado()");
    $facturasPorDia      = DB::select("CALL sp_reporte_facturas_por_dia(?, ?)", [$desde, $hasta]);
    $facturasPorCliente  = DB::select("CALL sp_reporte_facturas_por_cliente()");
    $salonesPorEstado    = DB::select("CALL sp_reporte_salones_estado()");

    // Convertir y normalizar
    $ventasMensuales     = $this->normalizarDatos($ventasMensuales, ['mes', 'total_ventas']);
    $topClientes         = $this->normalizarDatos($topClientes, ['cliente', 'rtn', 'total_facturado']);
    $serviciosPopulares  = $this->normalizarDatos($serviciosPopulares, ['descripcion', 'cantidad', 'ingresos']);
    $ingresosPorTipo     = $this->normalizarDatos($ingresosPorTipo, ['tipo', 'cantidad', 'ingresos']);
    $resumenPorTipo      = $this->normalizarDatos($resumenPorTipo, ['tipo_factura', 'cantidad', 'total']);
    $cotizaciones        = $this->normalizarDatos($cotizaciones, ['cod_cotizacion', 'cliente', 'rtn', 'fecha', 'fecha_validez', 'estado', 'total_cotizacion']);
    $entradas            = $this->normalizarDatos($entradas, ['cod_entrada', 'descripcion', 'total']);
    $reservaciones       = $this->normalizarDatos($reservaciones, ['nombre_evento', 'fecha_programa', 'hora_programada', 'horas_evento', 'cliente', 'rtn']);
    $inventario          = $this->normalizarDatos($inventario, ['cod_inventario', 'nombre', 'descripcion', 'precio_unitario', 'cantidad_disponible', 'estado']);
    $empleados           = $this->normalizarDatos($empleados, ['cod_empleado', 'nombre_empleado', 'dni', 'cargo', 'salario', 'fecha_contratacion', 'departamento_empresa', 'region_departamento', 'telefono', 'correo', 'usuario', 'rol', 'estado_usuario']);
    $facturasPorDia      = $this->normalizarDatos($facturasPorDia, ['dia', 'cantidad_facturas', 'total_facturado']);
    $facturasPorCliente  = $this->normalizarDatos($facturasPorCliente, ['cliente', 'rtn', 'cantidad_facturas', 'total_facturado']);
    $salonesPorEstado    = $this->normalizarDatos($salonesPorEstado, ['estado', 'cantidad']);

    // Imagen de gráfico (opcional)
    $nombreArchivo = session('grafico_pdf');
    $rutaImagen = $nombreArchivo ? storage_path('app/public/' . $nombreArchivo) : null;
    $graficoBase64 = null;

    if ($rutaImagen && file_exists($rutaImagen)) {
        $graficoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($rutaImagen));
    }

    // Renderizar PDF
    return PDF::loadView('pdf.reporte-resumen', compact(
        'ventasMensuales',
        'topClientes',
        'serviciosPopulares',
        'ingresosPorTipo',
        'resumenPorTipo',
        'cotizaciones',
        'entradas',
        'reservaciones',
        'inventario',
        'empleados',
        'facturasPorDia',
        'facturasPorCliente',
        'salonesPorEstado',
        'graficoBase64'
    ))->download('resumen-reportes.pdf');

    
}


private function normalizarDatos($data, $expectedKeys)
{
    $result = [];
    foreach (json_decode(json_encode($data), true) as $item) {
        $normalized = [];
        foreach ($expectedKeys as $key) {
            $normalized[$key] = $item[$key] ?? null;
        }
        $result[] = $normalized;
    }
    return $result;
}

}