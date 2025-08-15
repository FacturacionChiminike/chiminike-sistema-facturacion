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

        $dashboard = [
            "total_generado" => 0,
            "cliente_frecuente" => "Sin datos",
            "cantidad_cotizaciones_frecuente" => 0,
            "total_cotizaciones" => 0,
            "total_reservaciones" => 0,
            "total_eventos" => 0,
            "reservaciones_mes_actual" => 0,
        ];

        try {
            // Resumen de personas, empleados, clientes
            $response = Http::get("http://localhost:3000/personas");

            if ($response->successful()) {
                $resumen = $response->json();
            }

            // Total generado por cotizaciones completadas
            $responseTotal = Http::get("http://localhost:3000/dashboard/total-generado");

            if ($responseTotal->successful()) {
                $dashboard["total_generado"] = $responseTotal->json()["total_generado"] ?? 0;
            }

            // Cliente más frecuente en cotizaciones completadas
            $responseCliente = Http::get("http://localhost:3000/dashboard/cliente-frecuente");

            if ($responseCliente->successful()) {
                $clienteData = $responseCliente->json();
                $dashboard["cliente_frecuente"] = $clienteData["cliente"] ?? "Sin datos";
                $dashboard["cantidad_cotizaciones_frecuente"] = $clienteData["cantidad_cotizaciones"] ?? 0;
            }

            // Totales de cotizaciones, reservaciones, eventos y reservaciones del mes actual
            $responseTotales = Http::get("http://localhost:3000/dashboard/totales");

            if ($responseTotales->successful()) {
                $totalesData = $responseTotales->json();
                $dashboard["total_cotizaciones"] = $totalesData["total_cotizaciones"] ?? 0;
                $dashboard["total_reservaciones"] = $totalesData["total_reservaciones"] ?? 0;
                $dashboard["total_eventos"] = $totalesData["total_eventos"] ?? 0;
                $dashboard["reservaciones_mes_actual"] = $totalesData["reservaciones_mes_actual"] ?? 0;
            }
        } catch (\Exception $e) {
            logger()->error("Error al obtener datos del dashboard: " . $e->getMessage());
            return back()->with('error', 'Error al cargar el dashboard: ' . $e->getMessage());
        }

        return view('dashboard', compact('resumen', 'dashboard'));
    }
}
