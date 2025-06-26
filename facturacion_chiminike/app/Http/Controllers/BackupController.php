<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Storage::disk('backups')->files();
        return view('backup', compact('backups')); // tu vista es backup.blade.php
    }

    public function crearBackup()
    {
        \Artisan::call('backup:run');
        return response()->json(['success' => true, 'message' => 'Backup creado correctamente.']);
    }


   public function restaurarBackup(Request $request)
{
    $request->validate([
        'archivo' => 'required|file'
    ]);

    $path = $request->file('archivo')->storeAs('backups', 'restore_temp.sql');

    $mysqlPath = '"C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysql.exe"';

    // Armamos las rutas bien escapadas
    $sqlFile = storage_path('app/' . $path);
    $sqlFileEscaped = '"' . $sqlFile . '"'; // <- escapamos aquí

    // ATENCIÓN: el < debe ir fuera de comillas
    $command = sprintf(
        'cmd /c %s -h "%s" -u "%s" -p"%s" "%s" < %s',
        $mysqlPath,
        env('DB_HOST'),
        env('DB_USERNAME'),
        env('DB_PASSWORD'),
        env('DB_DATABASE'),
        $sqlFileEscaped
    );

    $output = null;
    $return_var = null;
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        return response()->json(['success' => false, 'message' => '❌ Error al restaurar el backup. Código: ' . $return_var]);
    }

    return response()->json(['success' => true, 'message' => '✅ Backup restaurado correctamente.']);
}


    public function descargarBackup($file)
    {
        if (!Storage::disk('backups')->exists($file)) {
            abort(404, 'Backup no encontrado.');
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('backups');

        return $disk->download($file);
    }
}
