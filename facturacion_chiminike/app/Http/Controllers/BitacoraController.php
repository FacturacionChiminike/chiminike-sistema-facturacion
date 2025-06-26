<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $query = [
            'cod_usuario' => $request->input('cod_usuario', 0),
            'fecha_inicio' => $request->input('fecha_inicio', null),
            'fecha_fin' => $request->input('fecha_fin', null),
            'objeto' => $request->input('objeto', ''),
            'page' => $page,
        ];

        try {
            $response = Http::get('http://localhost:3000/bitacora', $query);
            $bitacora = $response->json();

            return view('bitacora', compact('bitacora', 'page'));  // ojo aquí también mandas el page para la paginación
        } catch (\Exception $e) {
            return view('bitacora')->with('error', 'No se pudo obtener la bitácora');
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
