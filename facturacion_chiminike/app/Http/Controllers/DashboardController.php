<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $resumen = [
            "total_personas" => 0,
            "total_empleados" => 0,
            "total_clientes" => 0,
            "empleados_activos" => 0,
            "empleados_inactivos" => 0,
        ];

        try {
            $response = Http::get("http://localhost:3000/personas");

            if ($response->successful()) {
                $resumen = $response->json();
            }
        } catch (\Exception $e) {
            // Puedes loguear el error si querés
            logger()->error("Error al obtener resumen: " . $e->getMessage());
        }

        return view('dashboard', compact('resumen'));
    }
}
