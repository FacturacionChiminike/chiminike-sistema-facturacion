<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DescuentoController extends Controller
{
    // URL de tu API externa
    protected $api = 'http://localhost:3000/api';

    /**
     * Devuelve la vista blade donde cargas el HTML + JS.
     */
    public function vista()
    {
        return view('Pages.gestionar-descuentos');
    }

    /**
     * GET /api/descuentos
     * Trae el único registro de descuentos.
     */
    public function listar()
    {
        try {
            $resp = Http::get("{$this->api}/descuentos");

            if (! $resp->ok()) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al obtener descuentos'
                ], 500);
            }

            // Suponemos que la API externa devuelve directamente el objeto:
            // { cod_descuento, descuento_otorgado, rebaja_otorgada, importe_exento, ... }
            return response()->json($resp->json());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión a la API'
            ], 500);
        }
    }

    /**
     * PUT /api/descuentos/{id}
     * Actualiza el único registro (ID fijo).
     */
    public function guardar(Request $request, $id)
    {
        // Validaciones mínimas
        $data = $request->validate([
            'descuento_otorgado' => 'required|numeric|min:0',
            'rebaja_otorgada'    => 'required|numeric|min:0',
            'importe_exento'     => 'required|numeric|min:0',
        ]);

        try {
            $resp = Http::put("{$this->api}/descuentos/{$id}", $data);

            if (! $resp->ok()) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Error al actualizar descuentos'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'mensaje' => 'Descuentos actualizados correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error de conexión a la API'
            ], 500);
        }
    }
}
