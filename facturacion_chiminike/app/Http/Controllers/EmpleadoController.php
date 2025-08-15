<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Exports\EmpleadosExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


class EmpleadoController extends Controller
{
    public function index()
    {
        try {

            $responseEmpleados = Http::get('http://localhost:3000/empleados');
            $empleados = $responseEmpleados->successful() ? $responseEmpleados->json() : [];


            $responseRoles = Http::get('http://localhost:3000/role.date');
            $roles = $responseRoles->successful() ? $responseRoles->json() : [];


            $responseMunicipios = Http::get('http://localhost:3000/municipio.date');
            $municipios = $responseMunicipios->successful() ? $responseMunicipios->json() : [];


            $responseDepartamentos = Http::get('http://localhost:3000/dep.emp');
            $departamentos = $responseDepartamentos->successful() ? $responseDepartamentos->json() : [];


            $responseTiposUsuario = Http::get('http://localhost:3000/tip.user');
            $tiposUsuario = $responseTiposUsuario->successful() ? $responseTiposUsuario->json() : [];


            return view('empleado', compact('empleados', 'roles', 'municipios', 'departamentos', 'tiposUsuario'));
        } catch (\Exception $e) {
            // Si algo falla, mejor evitar que explote la  por vista
            return view('empleado', [
                'empleados' => [],
                'roles' => [],
                'municipios' => [],
                'departamentos' => [],
                'tiposUsuario' => []
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $token = session('token');

        $data = [
            "nombre_persona" => $request->input("nombre_persona"),
            "fecha_nacimiento" => $request->input("fecha_nacimiento"),
            "sexo" => $request->input("sexo"),
            "dni" => $request->input("dni"),
            "correo" => $request->input("correo"),
            "telefono" => $request->input("telefono"),
            "direccion" => $request->input("direccion"),
            "cod_municipio" => $request->input("cod_municipio"),
            "cargo" => $request->input("cargo"),
            "salario" => $request->input("salario"),
            "fecha_contratacion" => $request->input("fecha_contratacion"),
            "cod_departamento_empresa" => $request->input("cod_departamento_empresa"),
            "cod_rol" => $request->input("cod_rol"),
            "estado" => $request->input("estado")
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put("http://localhost:3000/empleados/{$id}", $data);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'mensaje' => 'Empleado actualizado correctamente.',
                'empleado_actualizado' => $response->json()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al actualizar el empleado.',
                'error' => $response->json()
            ], $response->status());
        }
    }


    public function store(Request $request)
    {
        // Validar campos
        $request->validate([
            'nombre_persona' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'dni' => 'required|numeric',
            'correo' => 'required|email',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string',
            'cod_municipio' => 'required|integer',
            'cargo' => 'required|string',
            'fecha_contratacion' => 'required|date',
            'cod_rol' => 'required|integer',
            'cod_tipo_usuario' => 'required|integer',
            'salario' => 'required|numeric|min:0',
            'cod_departamento_empresa' => 'required|integer',
        ]);

        // ✅ Generación del nombre de usuario en el nuevo formato
        $partes_nombre = explode(' ', $request->nombre_persona);
        $primera_letra = strtolower(substr($partes_nombre[0], 0, 1));
        $apellido_paterno = strtolower(end($partes_nombre));
        $sufijo = substr($request->dni, -3);
        $nombre_usuario = $primera_letra . $apellido_paterno . '.' . $sufijo;

        $contrasena = Str::random(10);

        $usuario = session('usuario');
        $creado_por = $usuario['nombre_usuario'] ?? 'sistema';

        // Preparar datos
        $data = $request->all();
        $data['nombre_usuario'] = $nombre_usuario;
        $data['contrasena'] = $contrasena;
        $data['creado_por'] = $creado_por;

        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('http://localhost:3000/empleados.insert', $data);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'mensaje' => 'Empleado registrado correctamente. Credenciales enviadas por correo.',
                'usuario_generado' => $nombre_usuario,
                'contrasena_generada' => $contrasena
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mensaje' => 'No se pudo registrar el empleado.',
                'error' => $response->body()
            ], $response->status());
        }
    }


    public function exportarExcel()
    {
        $empleados = Http::get('http://localhost:3000/empleados')->json();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Empleados');


        $encabezados = ['DNI', 'Nombre', 'Cargo', 'Departamento', 'Salario', 'Estado', 'Teléfono', 'Correo', 'Fecha Contratación'];
        $sheet->fromArray($encabezados, null, 'A1');


        $row = 2;
        foreach ($empleados as $emp) {
            $sheet->fromArray([
                $emp['dni'],
                $emp['nombre_persona'],
                $emp['cargo'],
                $emp['departamento_empresa'],
                number_format($emp['salario'], 2),
                $emp['estado'],
                $emp['telefono'],
                $emp['correo'],
                $emp['fecha_contratacion']
            ], null, 'A' . $row++);
        }


        $writer = new Xlsx($spreadsheet);
        $fileName = 'empleados_' . date('Ymd_His') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }



    public function exportarPDF()
    {
        $empleados = Http::get('http://localhost:3000/empleados')->json();
        $pdf = Pdf::loadView('empleados.pdf', compact('empleados'))->setPaper('a4', 'landscape');
        return $pdf->download('empleados.pdf');
    }
}
