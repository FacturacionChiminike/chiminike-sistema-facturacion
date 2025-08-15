<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log; 

class BackupDatabase extends Command
{
    protected $signature = 'backup:run';
    protected $description = 'Realiza un respaldo completo de la base de datos';

    public function handle(): void
    {
        $filename = 'backup_' . date('Ymd_His') . '.sql';

        $mysqldumpPath = '"C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe"';

        $command = sprintf(
            '%s -h "%s" -u "%s" -p"%s" "%s" > "%s"',
            $mysqldumpPath,
            env('DB_HOST'),
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            storage_path('app/backups/' . $filename)
        );

        
        Log::info('Comando de mysqldump ejecutado:', ['command' => $command]);

        $output = null;
        $return_var = null;
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            $this->error("Error al crear el backup. Código de salida: " . $return_var);
        } else {
            $this->info('Backup creado correctamente: ' . $filename);
        }
    }
}
