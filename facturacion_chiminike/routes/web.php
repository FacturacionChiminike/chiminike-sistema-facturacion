<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeguridadController;
use App\Http\Controllers\CaiController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\RecorridoEscolarController;
use App\Http\Controllers\AdicionalController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\ObjetoController;
use App\Http\Controllers\ComplementosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservacionesController;
use App\Http\Middleware\VerificaSesion;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\ReportesController;
// RUTAS PÚBLICAS ==========================

Route::get('/login', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'autenticar'])->name('login.enviar');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/recuperar-contrasena', [LoginController::class, 'recuperar'])->name('password.email');
Route::get('/resetear', [LoginController::class, 'mostrarFormularioReset'])->name('password.reset');
Route::post('/resetear', [LoginController::class, 'resetearContrasena'])->name('password.update');

Route::get('/verificar-2fa/{cod_usuario}', [LoginController::class, 'mostrarFormulario2FA'])->name('verificar.formulario');
Route::post('/verificar-2fa', [LoginController::class, 'verificar2FA'])->name('verificar.codigo');

Route::post('/api/autenticar', [LoginController::class, 'autenticarDesdeJS']);



Route::get('/primer-inicio', [LoginController::class, 'mostrarVistaPrimerAcceso'])->name('primer.acceso');

Route::post('/actualizar-password', [LoginController::class, 'actualizarPasswordPrimerIngreso'])->name('actualizar.password');
Route::post('/recuperar-preguntas-usuario', [LoginController::class, 'obtenerPreguntasUsuario'])->name('password.validar.usuario');
Route::post('/validar-respuestas', [LoginController::class, 'validarPreguntasYActualizarContrasena'])->name('validar.respuestas');

Route::get('/iniciar-sesion', function () {
    return view('iniciarsesion');
})->name('login.form');

Route::get('/check-session', function () {
    return response()->json(['activa' => session()->has('usuario')]);
})->name('check.session');

Route::get('/logn', function () {
    return view('logn');
})->name('logn');


Route::get('/prueba', function () {
    return '¡Laravel está funcionando, Mike! 😎';
});


use App\Http\Controllers\FacturacionController;



// RUTAS PROTEGIDAS ==========================

Route::middleware([VerificaSesion::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // EMPLEADOS
    Route::get('/empleados', [EmpleadoController::class, 'index']);
    Route::get('/empleados/crear', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
    Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
    Route::get('/empleados/exportar/excel', [EmpleadoController::class, 'exportarExcel'])->name('empleados.excel');
    Route::get('/empleados/exportar/pdf', [EmpleadoController::class, 'exportarPDF'])->name('empleados.pdf');

    // COTIZACIONES
    // Mostrar TODAS completadas
    Route::get('/eventos/completadas', [EventosController::class, 'completadas'])->name('eventos.completadas');
    Route::get('/eventos/expiradas', [EventosController::class, 'expiradas'])->name('eventos.expiradas');



    // CLIENTES
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/{id}/get', [ClienteController::class, 'show'])->name('clientes.show');
    Route::post('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

    // PERMISOS DE USUARIO
    Route::get('/userpermisos', [LoginController::class, 'vistaPermisos']);
    Route::get('/permisos-usuarios', [LoginController::class, 'obtenerPermisosUsuarios']);
    Route::post('/permisos/actualizar', [LoginController::class, 'actualizarPermiso']);

    // ROLES
    Route::get('/roles', [SeguridadController::class, 'mostrarRoles'])->name('roles.mostrar');
    Route::post('/roles/insertar', [SeguridadController::class, 'insertarRol'])->name('roles.insertar');
    Route::put('/roles/actualizar/{id}', [SeguridadController::class, 'actualizarRol'])->name('roles.actualizar');
    Route::delete('/roles/eliminar/{id}', [SeguridadController::class, 'eliminarRol'])->name('roles.eliminar');

    // CAI
    Route::get('/cai', [CaiController::class, 'index'])->name('cai');
    Route::post('/cai', [CaiController::class, 'store'])->name('cai.store');
    Route::put('/cai/{id}', [CaiController::class, 'update'])->name('cai.update');
    Route::delete('/cai/{id}', [CaiController::class, 'destroy'])->name('cai.destroy');

    // PERMISOS
    Route::get('/permisos', [SeguridadController::class, 'mostrarPermisos'])->name('permisos.mostrar');
    Route::post('/permisos', [SeguridadController::class, 'insertarPermiso'])->name('permisos.insertar');
    Route::put('/permisos/{id}', [SeguridadController::class, 'actualizarPermiso'])->name('permisos.actualizar');
    Route::get('/permisos/{id}', [SeguridadController::class, 'mostrarPermisoPorId'])->name('permisos.mostrarUno');
    Route::delete('/permisos/{id}', [SeguridadController::class, 'eliminarPermiso'])->name('permisos.eliminar');

    // SALONES
    Route::resource('/salones', SalonController::class)->except('show');
    Route::get('/salones/{id}/edit', [SalonController::class, 'edit']);
    Route::put('/salones/{id}', [SalonController::class, 'update']);
    Route::delete('/salones/{id}', [SalonController::class, 'destroy']);
    Route::post('/salones', [SalonController::class, 'store'])->name('salones.store');
    // INVENTARIO
    Route::resource('/inventario', InventarioController::class)->except('show');

    // PAQUETES
    Route::resource('/paquetes', RecorridoEscolarController::class)->except('show');

    // ADICIONALES
    Route::resource('/adicionales', AdicionalController::class)->except('show');

    // ENTRADAS
    Route::get('/entradas', [EntradaController::class, 'index'])->name('entradas.index');
    Route::get('/entradas/show/{id}', [EntradaController::class, 'show']);
    Route::post('/entradas/store', [EntradaController::class, 'store']);
    Route::put('/entradas/update/{id}', [EntradaController::class, 'update']);
    Route::delete('/entradas/destroy/{id}', [EntradaController::class, 'destroy']);

    // COMPLEMENTOS
    Route::get('/complementos', [ComplementosController::class, 'index'])->name('complementos.index');
    Route::post('/complementos/adicionales', [ComplementosController::class, 'storeAdicional']);
    Route::get('/complementos/adicionales/{id}', [ComplementosController::class, 'showAdicional']);
    Route::put('/complementos/adicionales/{id}', [ComplementosController::class, 'updateAdicional']);
    Route::delete('/complementos/adicionales/{id}', [ComplementosController::class, 'destroyAdicional']);
    Route::post('/complementos/paquetes', [ComplementosController::class, 'storePaquete']);
    Route::get('/complementos/paquetes/{id}', [ComplementosController::class, 'showPaquete']);
    Route::put('/complementos/paquetes/{id}', [ComplementosController::class, 'updatePaquete']);
    Route::delete('/complementos/paquetes/{id}', [ComplementosController::class, 'destroyPaquete']);
    Route::post('/complementos/entradas', [ComplementosController::class, 'storeEntrada']);
    Route::get('/complementos/entradas/{id}', [ComplementosController::class, 'showEntrada']);
    Route::put('/complementos/entradas/{id}', [ComplementosController::class, 'updateEntrada']);
    Route::delete('/complementos/entradas/{id}', [ComplementosController::class, 'destroyEntrada']);
     // Rutas para Libros
Route::post('/complementos/libros', [ComplementosController::class, 'storeLibro']);
Route::get('/complementos/libros/{id}', [ComplementosController::class, 'showLibro']);
Route::put('/complementos/libros/{id}', [ComplementosController::class, 'updateLibro']);
Route::delete('/complementos/libros/{id}', [ComplementosController::class, 'destroyLibro']);


    // BACKUP
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/crear', [BackupController::class, 'crearBackup'])->name('backup.crear');
    Route::post('/backup/restaurar', [BackupController::class, 'restaurarBackup'])->name('backup.restaurar');
    Route::get('/backup/descargar/{file}', [BackupController::class, 'descargarBackup'])
        ->where('file', '.*')->name('backup.descargar');

    // BITÁCORA
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora');
    Route::get('/bitacora/exportar', [BitacoraController::class, 'exportarPDF'])->name('bitacora.exportar');

    // OBJETOS
    Route::get('/objetos', [ObjetoController::class, 'index']);
    Route::get('/objetos/{id}', [ObjetoController::class, 'show']);
    Route::post('/objetos.save', [ObjetoController::class, 'store']);
    Route::put('/objetos/{id}', [ObjetoController::class, 'update']);
    Route::delete('/objetos/{id}', [ObjetoController::class, 'destroy']);
    Route::get('/vista-objetos', [ObjetoController::class, 'vistaObjetos']);

    // CATÁLOGOS
    Route::get('/catalogo/roles', [SeguridadController::class, 'soloRoles']);
    Route::get('/catalogo/objetos', [SeguridadController::class, 'soloObjetos']);

    // USUARIOS
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');

    // Vistas principales
    Route::get('/generador-facturas', [FacturacionController::class, 'index']);
    Route::get('/registro-facturas', fn() => view('Pages.registro-facturas'));

    // ----> Agrupamos todo lo que consume JS bajo /api
    Route::get('/generador-facturas', [FacturacionController::class, 'index']);
    Route::get('/generador-facturasR',  fn() => view('Pages.generador-facturasRecorridos'));
    Route::get('/generador-facturasT',  fn() => view('Pages.generador-facturasTaquilla'));
    Route::get('/generador-facturasE',  fn() => view('Pages.generador-facturasEventos'));
    Route::get('/generador-facturasL',  fn() => view('Pages.generador-facturasLibros'));
       Route::get('/generador-facturasO',  fn() => view('Pages.generador-facturasObras'));
    Route::get('/registro-facturas', fn() => view('Pages.registro-facturas'));
      Route::get('/registroT', fn() => view('Pages.registroTaquillas'));
       Route::get('/registroR', fn() => view('Pages.registroRecorridos'));
        Route::get('/registroE', fn() => view('Pages.registroEventos'));
         Route::get('/registroL', fn() => view('Pages.registroLibros'));
             Route::get('/registroO', fn() => view('Pages.registroObras'));
    Route::get('/gestionar-descuentos', function () {
        return view('Pages.gestionar-descuentos');
    });

    // ----> Agrupamos todo lo que consume JS bajo /api
    Route::prefix('api')->group(function () {
        // Catálogos y entidades básicas
        Route::get('municipios',            [FacturacionController::class, 'municipios']);
        Route::get('clientes',              [FacturacionController::class, 'clientes']);
        Route::get('empleados',             [FacturacionController::class, 'empleados']);
        Route::get('eventos',               [FacturacionController::class, 'eventos']);
        Route::get('eventos/{id}',          [FacturacionController::class, 'detallesEvento']);
        Route::post('eventos-completo',     [FacturacionController::class, 'crearEventoCompleto']);
        Route::get('boletos-taquilla',      [FacturacionController::class, 'boletosTaquilla']);
        Route::get('adicionales',           [FacturacionController::class, 'adicionales']);
        Route::get('paquetes',              [FacturacionController::class, 'paquetes']);
        Route::get('inventario',            [FacturacionController::class, 'inventario']);
        Route::get('libros',                [FacturacionController::class, 'libros']);
        Route::get('salones',    [FacturacionController::class, 'salones']);
        Route::put('eventos/{id}/completar', [FacturacionController::class, 'completarEvento']);


        // Correlativos y CAI
        Route::get('correlativo/activo',    [FacturacionController::class, 'correlativoActivo']);
        Route::get('cai/activo',            [FacturacionController::class, 'caiActivo']);
        Route::put('correlativo/{id}',      [FacturacionController::class, 'actualizarCorrelativo']);

        // Clientes
        Route::post('clientes',             [FacturacionController::class, 'nuevoCliente']);

        // Facturas y detalle
        Route::get('facturas',                       [FacturacionController::class, 'listarFacturas']);
        Route::get('facturas/{id}',                  [FacturacionController::class, 'getFactura']);
        Route::post('facturas',                      [FacturacionController::class, 'guardarFactura']);
        Route::put('facturas/{id}',                  [FacturacionController::class, 'actualizarFactura']);
        Route::delete('facturas/{id}',               [FacturacionController::class, 'eliminarFactura']);

        Route::get('facturas/{id}/detalle',          [FacturacionController::class, 'getDetalleFactura']);
        Route::post('facturas/detalle',              [FacturacionController::class, 'guardarDetalleFactura']);
        Route::put('facturas/detalle-factura/{id}',  [FacturacionController::class, 'actualizarDetalleFactura']);
        Route::delete('facturas/detalle-factura/{id}', [FacturacionController::class, 'eliminarDetalleFactura']);

        //descuentos
        Route::get('descuentos', [DescuentoController::class, 'listar']);
        Route::put('descuentos/{id}', [DescuentoController::class, 'guardar']);
    });

    Route::get('/facturas/pdf/{id}', [FacturacionController::class, 'descargarFactura'])
        ->name('facturas.pdf');
    Route::post('facturas/{id}/enviar-correo', [FacturacionController::class, 'enviarCorreo']);



    //ultima que mando luis 18/7/2025
    Route::put('eventos/{id}/completar', [FacturacionController::class, 'completarEvento']);

    Route::get('/reservaciones', [ReservacionesController::class, 'index'])->name('reservaciones.index');
    Route::get('/reservaciones/{id}', [ReservacionesController::class, 'show'])->name('reservaciones.show');
    Route::get('/reservaciones/pdf/{id}', [ReservacionesController::class, 'generarPDF'])->name('reservaciones.pdf');
    Route::put('/reservaciones/{id}', [ReservacionesController::class, 'update'])->name('reservaciones.update');
    Route::post('/reservaciones/{id}/enviar-correo', [ReservacionesController::class, 'enviarCorreoReservacion']);



    Route::get('/cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones.index');
    Route::post('/cotizaciones', [CotizacionController::class, 'store'])->name('cotizacion.store');
    Route::get('/cotizacion/{id}/detalle', [CotizacionController::class, 'detalle'])->name('cotizacion.detalle');
    Route::get('/nueva-cotizacion', fn() => view('newcotizacion'))->name('cotizacion.index');
    Route::put('/cotizacion/{id}', [CotizacionController::class, 'update'])->name('cotizacion.update');
    Route::get('/cotizaciones/pdf/{id}', [CotizacionController::class, 'generarPDF'])->name('cotizacion.pdf');
    Route::delete('/cotizaciones/{id}', [CotizacionController::class, 'destroy'])->name('cotizaciones.destroy');
    Route::post('/cotizaciones/{id}/enviar-correo', [CotizacionController::class, 'enviarCorreo']);


    //josue





    // Vistas principales
  Route::get('/reportes', [ReportesController::class, 'vistaReportes'])->name('reportes');
    Route::get('/reportesF',  fn() => view('Pages.reportesFAC'));
    Route::get('/reportesE',  fn() => view('Pages.reportesEVEN'));
    Route::get('/reportesI',  fn() => view('Pages.reportesINV'));
    Route::get('/reportesP',  fn() => view('Pages.reportesPER'));
    Route::get('/reportes/top-clientes', [ReportesController::class, 'topClientes'])->name('top.clientes.view');
    Route::get('/reportes/exportar-resumen', [ReportesController::class, 'exportarResumen'])->name('reportes.exportar');
    Route::get('/reporte/resumen/excel', [ReportesController::class, 'exportarResumenExcel'])->name('reportes.exportar.excel');

  // Vistas principales de reportes
Route::get('/reportes', [ReportesController::class, 'vistaReportes'])->name('reportes');
Route::get('/reportes/top-clientes', [ReportesController::class, 'topClientes'])->name('top.clientes.view');
Route::get('/reportes/exportar-resumen', [ReportesController::class, 'exportarResumen'])->name('reportes.exportar');

// Rutas API para reportes
Route::get('/api/reportes/resumen-general', [ReportesController::class, 'resumenGeneral']);
Route::get('/api/reportes/ventas-mensuales', [ReportesController::class, 'ventasMensuales']);
Route::get('/api/reportes/top-clientes', [ReportesController::class, 'topClientesApi']);
Route::get('/api/reportes/servicios-populares', [ReportesController::class, 'serviciosPopulares']);
Route::get('/api/reportes/ingresos-por-tipo', [ReportesController::class, 'ingresosPorTipo']);
Route::get('/api/reportes/cotizaciones', [ReportesController::class, 'cotizaciones']);
Route::get('/api/reportes/entradas', [ReportesController::class, 'entradas']);
Route::get('/api/reportes/inventario', [ReportesController::class, 'inventario']);
Route::get('/api/reportes/facturas/resumen-por-tipo-factura', [ReportesController::class, 'resumenPorTipoFactura']);
Route::get('/api/reportes/total-clientes', [ReportesController::class, 'totalClientes']);
Route::get('/api/reportes/eventos', [ReportesController::class, 'eventos']);
Route::get('/api/reportes/total-eventos', [ReportesController::class, 'totalEventos']);
Route::get('/api/reportes/clientes', [ReportesController::class, 'clientes']);
Route::get('/api/reportes/empleados', [ReportesController::class, 'empleados']);
Route::get('/api/reportes/total-empleados', [ReportesController::class, 'totalEmpleados']);
Route::get('/api/reportes/ventas-lunes-viernes', [ReportesController::class, 'ventasLunesViernes']);
Route::get('/api/reportes/ventas-weekend', [ReportesController::class, 'ventasChiminikeWeekend']);
Route::get('/api/reportes/total-cotizaciones', [ReportesController::class, 'totalCotizaciones']);
Route::get('/api/reportes/reservaciones', [ReportesController::class, 'reservaciones']);
Route::get('/api/reportes/total-reservaciones', [ReportesController::class, 'totalReservaciones']);
Route::get('/api/reportes/salones-estado', [ReportesController::class, 'salonesEstado']);

// Exportación de reportes
Route::get('/reporte/resumen/pdf', [ReportesController::class, 'generarResumenPDF'])->name('reportes.pdf');
Route::post('/guardar-imagen-grafico', [ReportesController::class, 'guardarGrafico']);
Route::get('/reportes/excel', [ReportesController::class, 'exportarExcel'])->name('reportes.excel');
Route::get('/reporte/facturas/pdf',          [ReportesController::class, 'generarFacturasPDF'])         ->name('reportes.facturas.pdf');
Route::get('/reporte/cotizaciones/pdf',      [ReportesController::class, 'generarCotizacionesPDF'])     ->name('reportes.cotizaciones.pdf');
Route::get('/reporte/entradas/pdf',          [ReportesController::class, 'generarEntradasPDF'])         ->name('reportes.entradas.pdf');
Route::get('/reporte/inventario/pdf',        [ReportesController::class, 'generarInventarioPDF'])       ->name('reportes.inventario.pdf');
Route::get('/reporte/reservaciones/pdf',     [ReportesController::class, 'generarReservacionesPDF'])    ->name('reportes.reservaciones.pdf');
Route::get('/reporte/empleados/pdf',         [ReportesController::class, 'generarEmpleadosPDF'])        ->name('reportes.empleados.pdf');
Route::get('/reporte/salones-estado/pdf',    [ReportesController::class, 'generarSalonesEstadoPDF'])    ->name('reportes.salones.pdf');
Route::get('/reporte/eventos/pdf',           [ReportesController::class, 'generarEventosPDF'])          ->name('reportes.eventos.pdf');
Route::get('/reporte/clientes/pdf',          [ReportesController::class, 'generarClientesPDF'])         ->name('reportes.clientes.pdf');
Route::post('/guardar-imagen-grafico', [ReportesController::class, 'guardarGrafico']);
Route::get('/reportes/excel', [ReportesController::class, 'exportarExcel'])->name('reportes.excel');
});
