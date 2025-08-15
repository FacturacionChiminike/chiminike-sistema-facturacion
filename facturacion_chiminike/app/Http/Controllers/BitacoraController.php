<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class BitacoraController extends Controller
{

    private function formatearResumen($datos, $titulo = '')
    {
        if (!is_array($datos) || empty($datos)) {
            return "<b>{$titulo}:</b> No hay datos disponibles.<br>";
        }

        $html = $titulo ? "<b>{$titulo}:</b><br>" : '';
        $html .= "<ul style='padding-left: 1rem;'>";

        foreach ($datos as $clave => $valor) {
            if (is_array($valor)) {
                $html .= "<li><strong>" . ucfirst(str_replace('_', ' ', $clave)) . ":</strong><br>" . $this->formatearResumen($valor) . "</li>";
            } elseif (!is_null($valor) && $valor !== '') {
                $html .= "<li><strong>" . ucfirst(str_replace('_', ' ', $clave)) . ":</strong> " . e($valor) . "</li>";
            }
        }

        $html .= "</ul>";
        return $html;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $query = [
            'cod_usuario' => $request->input('cod_usuario', 0),
            'fecha_inicio' => $request->input('fecha_inicio', null),
            'fecha_fin' => $request->input('fecha_fin', null),
            'objeto' => $request->input('objeto', ''),
            'limit' => $limit,
            'offset' => $offset,
        ];

        try {
            $response = Http::get('http://localhost:3000/bitacora', $query);

            if ($response->successful()) {
                $bitacora = $response->json();

                foreach ($bitacora as &$registro) {
                    $resumen = '';

                    if (isset($registro['datos_antes']) && isset($registro['datos_despues'])) {
                        $resumen .= $this->formatearResumen($registro['datos_antes'], '🕒 Datos Antes');
                        $resumen .= '<hr>';
                        $resumen .= $this->formatearResumen($registro['datos_despues'], '🚀 Datos Después');
                    } elseif (isset($registro['datos_despues'])) {
                        $resumen .= $this->formatearResumen($registro['datos_despues'], '📝 Detalles');
                    } elseif (isset($registro['datos'])) {
                        $decoded = json_decode($registro['datos'], true);
                        $resumen .= $this->formatearResumen($decoded, '📝 Detalles');
                    }

                    $registro['resumen_legible'] = $resumen;
                }

                return view('bitacora', compact('bitacora', 'page'));
            } else {
                return view('bitacora')->with('error', 'Error al obtener los datos de la bitácora');
            }
        } catch (\Exception $e) {
            return view('bitacora')->with('error', 'No se pudo conectar con el servicio de bitácora');
        }
    }






    public function exportarPDF(Request $request)
    {
        $query = [
            'cod_usuario' => $request->input('cod_usuario', 0),
            'fecha_inicio' => $request->input('fecha_inicio', null),
            'fecha_fin' => $request->input('fecha_fin', null),
            'objeto' => $request->input('objeto', ''),
            'page' => 1
        ];

        $response = Http::get('http://localhost:3000/bitacora', $query);
        $bitacora = $response->json();

        $pdf = Pdf::loadView('bitacora.pdf', compact('bitacora'));
        return $pdf->download('bitacora.pdf');
    }
}
