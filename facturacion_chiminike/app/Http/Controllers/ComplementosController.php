<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComplementosController extends Controller
{
    public function index()
    {
        try {
            $adicionales = Http::get('http://localhost:3000/adicionales')->json();
            $paquetes = Http::get('http://localhost:3000/paquetes')->json();
            $entradas = Http::get('http://localhost:3000/entradas')->json();

            return view('complementos', compact('adicionales', 'paquetes', 'entradas'));

        } catch (\Exception $e) {
            return view('complementos', [
                'adicionales' => [],
                'paquetes' => [],
                'entradas' => []
            ]);
        }
    }

    // ======== ADICIONALES ========

    public function storeAdicional(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            Http::post('http://localhost:3000/adicionales', [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);
            return response()->json(['mensaje' => 'Adicional insertado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar adicional'], 500);
        }
    }

    public function showAdicional($id)
    {
        try {
            $adicional = Http::get("http://localhost:3000/adicionales/{$id}")->json();
            return response()->json($adicional);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function updateAdicional(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            Http::put("http://localhost:3000/adicionales/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);
            return response()->json(['mensaje' => 'Adicional actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al actualizar adicional'], 500);
        }
    }

    public function destroyAdicional($id)
    {
        try {
            Http::delete("http://localhost:3000/adicionales/{$id}");
            return response()->json(['mensaje' => 'Adicional eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al eliminar adicional'], 500);
        }
    }

    // ======== PAQUETES ========

    public function storePaquete(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            Http::post('http://localhost:3000/paquetes', [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);
            return response()->json(['mensaje' => 'Paquete insertado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar paquete'], 500);
        }
    }

    public function showPaquete($id)
    {
        try {
            $paquete = Http::get("http://localhost:3000/paquetes/{$id}")->json();
            return response()->json($paquete);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function updatePaquete(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric'
        ]);

        try {
            Http::put("http://localhost:3000/paquetes/{$id}", [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio
            ]);
            return response()->json(['mensaje' => 'Paquete actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al actualizar paquete'], 500);
        }
    }

    public function destroyPaquete($id)
    {
        try {
            Http::delete("http://localhost:3000/paquetes/{$id}");
            return response()->json(['mensaje' => 'Paquete eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al eliminar paquete'], 500);
        }
    }

    // ======== ENTRADAS ========

    public function storeEntrada(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric'
        ]);

        try {
            Http::post('http://localhost:3000/entradas', [
                'nombre' => $request->nombre,
                'precio' => $request->precio
            ]);
            return response()->json(['mensaje' => 'Entrada insertada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al insertar entrada'], 500);
        }
    }

    public function showEntrada($id)
    {
        try {
            $entrada = Http::get("http://localhost:3000/entradas/{$id}")->json();
            return response()->json($entrada);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function updateEntrada(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric'
        ]);

        try {
            Http::put("http://localhost:3000/entradas/{$id}", [
                'nombre' => $request->nombre,
                'precio' => $request->precio
            ]);
            return response()->json(['mensaje' => 'Entrada actualizada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al actualizar entrada'], 500);
        }
    }

    public function destroyEntrada($id)
    {
        try {
            Http::delete("http://localhost:3000/entradas/{$id}");
            return response()->json(['mensaje' => 'Entrada eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al eliminar entrada'], 500);
        }
    }
}
