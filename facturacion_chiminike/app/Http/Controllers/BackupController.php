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

        return view('backup', compact('backups'));
    }


   public function crearBackup()
{
    $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $path = storage_path('app/backups/' . $filename);

    $mysqldump = '/usr/bin/mysqldump';

    $dbHost = env('DB_HOST');
    $dbUser = env('DB_USERNAME');
    $dbPass = env('DB_PASSWORD');
    $dbName = env('DB_DATABASE');

    
    $command = "/bin/bash -c '{$mysqldump} -h{$dbHost} -u{$dbUser} -p\"{$dbPass}\" {$dbName} > \"{$path}\"'";

    $output = null;
    $return_var = null;
    exec($command, $output, $return_var);

    return response()->json([
        'success' => $return_var === 0,
        'command' => $command,
        'output' => $output,
        'return_code' => $return_var,
        'path_exists' => file_exists($path),
        'file_size' => file_exists($path) ? filesize($path) : 0
    ]);
}

   public function restaurarBackup(Request $request)
{
    $request->validate([
        'archivo' => 'required|file|mimes:sql,txt'
    ]);


    $path = $request->file('archivo')->storeAs('backups', 'restore_temp.sql');
    $sqlFile = storage_path('app/' . $path);


    if (!file_exists($sqlFile) || filesize($sqlFile) < 50) {
        return response()->json([
            'success' => false,
            'message' => ' El archivo .sql está vacío o no es válido',
        ]);
    }

   
    $dbHost = env('DB_HOST');
    $dbUser = env('DB_USERNAME');
    $dbPass = env('DB_PASSWORD');
    $dbName = env('DB_DATABASE');
    $mysqlPath = '/usr/bin/mysql'; 

  
    $command = "/bin/bash -c '{$mysqlPath} -h{$dbHost} -u{$dbUser} -p\"{$dbPass}\" {$dbName} < \"{$sqlFile}\"'";

   
    $output = null;
    $return_var = null;
    exec($command, $output, $return_var);

    
    if ($return_var !== 0) {
        return response()->json([
            'success' => false,
            'message' => ' Error al restaurar el backup',
            'debug' => [
                'cmd' => $command,
                'return' => $return_var,
                'output' => $output,
            ]
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => ' Backup restaurado correctamente'
    ]);
}



    public function descargarBackup($file)
    {
        if (!Storage::disk('backups')->exists($file)) {
            abort(404, 'Backup no encontrado.');
        }


        $disk = Storage::disk('backups');

        return $disk->download($file);
    }
}
