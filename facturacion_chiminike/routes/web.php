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
use App\Http\Middleware\VerificaSesion;
// RUTAS PÚBLICAS ==========================

Route::get('/', function () {
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

Route::get('/primer-inicio', function () {
    return view('oneinicio');
})->name('primer.inicio');

Route::post('/actualizar-password', [LoginController::class, 'actualizarPasswordPrimerIngreso'])->name('actualizar.password');

Route::get('/iniciar-sesion', function () {
    return view('iniciarsesion');
})->name('login.form');

Route::get('/check-session', function () {
    return response()->json(['activa' => session()->has('usuario')]);
})->name('check.session');

Route::get('/logn', function () {
    return view('logn');
})->name('logn');

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
    Route::get('/cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones.index');
    Route::post('/cotizaciones/guardar', [CotizacionController::class, 'store'])->name('cotizacion.store');
    Route::get('/cotizacion/{id}/enviar-correo', [CotizacionController::class, 'enviarCotizacionPorCorreo'])->name('cotizacion.enviar');
    Route::get('/cotizaciones/ver/{id}', [CotizacionController::class, 'verCotizacion'])->name('cotizacion.ver');
    Route::get('/nueva-cotizacion', fn () => view('newcotizacion'))->name('cotizacion.index');
    Route::get('/cotizacion/{id}/detalle', [CotizacionController::class, 'detalle']);


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
});