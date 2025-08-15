<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventosController extends Controller
{
    private $apiBase = 'http://localhost:3000';

    
    public function completadas()
    {
        try {
            $response = Http::get("{$this->apiBase}/cotizaciones/completadas");

            if (!$response->successful()) {
                return back()->with('error', 'Error al obtener cotizaciones completadas: Respuesta inválida del servidor.');
            }

            $cotizaciones = $response->json() ?? [];

            return view('eventos', compact('cotizaciones'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al obtener cotizaciones completadas: ' . $e->getMessage());
        }
    }

    
    public function expiradas()
    {
        try {
            $response = Http::get("{$this->apiBase}/cotizaciones/expiradas");

            if (!$response->successful()) {
                return back()->with('error', 'Error al obtener cotizaciones expiradas: Respuesta inválida del servidor.');
            }

            $cotizaciones = $response->json() ?? [];

            return view('expiradas', compact('cotizaciones'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al obtener cotizaciones expiradas: ' . $e->getMessage());
        }
    }
}
