<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ObjetoController extends Controller
{
    // Obtener todos los objetos
    public function index()
    {
        $response = Http::get("http://localhost:3000/objetos");

        if ($response->successful()) {
            return response()->json($response->json(), 200);
        } else {
            return response()->json(['mensaje' => 'Error al obtener objetos'], 500);
        }
    }

    // Obtener objeto por ID
    public function show($id)
    {
        $response = Http::get("http://localhost:3000/objetos/{$id}");

        if ($response->successful()) {
            return response()->json($response->json(), 200);
        } else {
            return response()->json(['mensaje' => 'Error al obtener objeto por ID'], 500);
        }
    }

    // Insertar objeto
    public function store(Request $request)
    {
        $response = Http::post("http://localhost:3000/objetos", [
            'tipo_objeto' => $request->input('tipo_objeto'),
            'descripcion' => $request->input('descripcion')
        ]);

        if ($response->successful()) {
            return response()->json($response->json(), 200);
        } else {
            return response()->json(['mensaje' => 'Error al insertar objeto'], 500);
        }
    }

    // Actualizar objeto
    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:3000/objetos/{$id}", [
            'tipo_objeto' => $request->input('tipo_objeto'),
            'descripcion' => $request->input('descripcion')
        ]);

        if ($response->successful()) {
            return response()->json($response->json(), 200);
        } else {
            return response()->json(['mensaje' => 'Error al actualizar objeto'], 500);
        }
    }

    // Eliminar objeto
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:3000/objetos/{$id}");

        if ($response->successful()) {
            return response()->json($response->json(), 200);
        } else {
            return response()->json(['mensaje' => 'Error al eliminar objeto'], 500);
        }
    }

    public function vistaObjetos()
    {
        $response = Http::get("http://localhost:3000/objetos");

        if ($response->successful()) {
            $objetos = $response->json();
            return view('objetos', compact('objetos'));
        } else {
            return view('objetos')->with('objetos', []);
        }
    }
}
