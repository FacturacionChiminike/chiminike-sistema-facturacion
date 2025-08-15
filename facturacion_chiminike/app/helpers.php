<?php

if (!function_exists('tienePermiso')) {
    function tienePermiso($objeto, $accion = 'mostrar')
    {
        $alias = [
            'Gestión de Seguridad' => 'Panel de administración',
        ];

        $objeto = $alias[$objeto] ?? $objeto;

        $permisos = session('permisos', []);

        foreach ($permisos as $permiso) {
            if (
                isset($permiso['objeto'], $permiso[$accion]) &&
                $permiso['objeto'] === $objeto &&
                $permiso[$accion]
            ) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('menuItems')) {
    function menuItems()
    {
        $items = [
            'Gestión de Personas' => [
                'icono' => 'bi bi-person-lines-fill',
                'submenus' => [
                    'Empleados' => [
                        'ruta' => '/empleados',
                        'icono' => 'bi bi-people-fill',
                        'objeto' => 'Gestión de empleados',
                    ],
                    'Clientes' => [
                        'ruta' => '/clientes',
                        'icono' => 'bi bi-person-fill',
                        'objeto' => 'Gestión de clientes',
                    ],
                ],
            ],
           'Gestión Facturacion' => [
                'icono' => 'bi bi-receipt',
                'submenus' => [
                    'Factura Recorridos Escolares' => [
                        'ruta'   => '/generador-facturasR',
                        'icono'  => 'bi bi-file-earmark-text',
                        'objeto' => 'Gestión Facturacion Recorridos Escolares',
                    ],
                    'Factura Taquilla General' => [
                        'ruta'   => '/generador-facturasT',
                        'icono'  => 'bi bi-file-earmark-text',
                        'objeto' => 'Gestión Facturacion Taquilla',
                    ],
                    'Factura Eventos' => [
                        'ruta'   => '/generador-facturasE',
                        'icono'  => 'bi bi-file-earmark-text',
                        'objeto' => 'Gestión Facturacion Eventos',
                    ],
                    'Factura Rocketlab' => [
                        'ruta'   => '/generador-facturasL',
                        'icono'  => 'bi bi-file-earmark-text',
                        'objeto' => 'Gestión Facturacion Roccketlab',
                    ],
                      'Factura Obras' => [
                        'ruta'   => '/generador-facturasO',
                        'icono'  => 'bi bi-file-earmark-text',
                        'objeto' => 'Gestión Facturacion Obras',
                    ],
                    'Registro Taquilla General' => [
                        'ruta'   => '/registroT',
                        'icono'  => 'bi bi-receipt',
                        'objeto' => 'Gestión Facturacion Taquilla',
                    ],
                  
                    'Registro Recorrido Escolar' => [
                        'ruta'   => '/registroR',
                        'icono'  => 'bi bi-receipt',
                        'objeto' => 'Gestión Facturacion Recorridos Escolares',
                    ],
                     'Registro Eventos' => [
                        'ruta'   => '/registroE',
                        'icono'  => 'bi bi-receipt',
                        'objeto' => 'Gestión Facturacion Eventos',
                    ],
                     'Registro Rocketlab' => [
                        'ruta'   => '/registroL',
                        'icono'  => 'bi bi-receipt',
                        'objeto' => 'Gestión Facturacion Roccketlab',
                    ],
                     'Registro Obras Teatrales' => [
                        'ruta'   => '/registroO',
                        'icono'  => 'bi bi-receipt',
                        'objeto' => 'Gestión Facturacion Obras',
                    ],
                    'Descuentos' => [
                        'ruta'   => '/gestionar-descuentos',
                        'icono'  => 'bi bi-percent',
                        'objeto' => 'Gestión Descuentos',
                    ],
                ],
            ],
            'Gestión de Evento' => [
                'icono' => 'bi bi-calendar-check',
                'submenus' => [
                    'Cotizaciones' => [
                        'ruta' => '/cotizaciones',
                        'icono' => 'bi bi-journal-text',
                        'objeto' => 'Gestión de cotizaciones',
                    ],
                    'Reservaciones' => [
                        'ruta' => '/reservaciones',
                        'icono' => 'bi bi-bookmark-check',
                        'objeto' => 'Gestión de cotizaciones',
                    ],
                    'Eventos' => [
                        'ruta' => '/eventos/completadas',
                        'icono' => 'bi bi-calendar-check',
                        'objeto' => 'Gestión de cotizaciones',
                    ],
                    'Eventos no Completados' => [
                        'ruta' => '/eventos/expiradas',
                        'icono' => 'bi bi-calendar-x',
                        'objeto' => 'Gestión de cotizaciones',
                    ],
                ],
            ],
            'Gestión de Recorridos Escolares' => [
                'icono' => 'bi bi-bus-front-fill',
                'submenus' => [
                    'Productos' => [
                        'ruta' => '/complementos',
                        'icono' => 'bi bi-box-seam',
                        'objeto' => 'Gestión de productos',
                    ],
                ],
            ],
            'Gestión de Salones' => [
                'icono' => 'bi bi-building',
                'submenus' => [
                    'Salones' => [
                        'ruta' => '/salones',
                        'icono' => 'bi bi-building',
                        'objeto' => 'Gestión de salones',
                    ],
                    'Inventario' => [ // NUEVO SUBMENU
                        'ruta' => '/inventario',
                        'icono' => 'bi bi-boxes',
                        'objeto' => 'Gestión de salones',
                    ],
                ],
            ],
            'Gestión de CAI' => [
                'icono' => 'bi bi-file-earmark-lock',
                'ruta' => '/cai',
                'objeto' => 'Gestión de CAI',
            ],
            'Gestión de Seguridad' => [
                'icono' => 'bi bi-shield-lock',
                'submenus' => [
                    'Permisos' => [
                        'ruta' => '/permisos',
                        'icono' => 'bi bi-person-gear',
                        'objeto' => 'Panel de administración',
                    ],
                    'Roles' => [
                        'ruta' => '/roles',
                        'icono' => 'bi bi-box',
                        'objeto' => 'Panel de administración',
                    ],
                    'Objetos' => [
                        'ruta' => '/vista-objetos',
                        'icono' => 'bi bi-hdd-stack',
                        'objeto' => 'Panel de administración',
                    ],
                    'Usuarios' => [
                        'ruta' => '/usuarios',
                        'icono' => 'bi bi-people',
                        'objeto' => 'Panel de administración',
                    ],
                    'Bitácora del sistema' => [
                        'ruta' => '/bitacora',
                        'icono' => 'bi bi-journal-text',
                        'objeto' => 'Bitácora del sistema',
                    ],
                    'Gestión de Backup' => [
                        'ruta' => '/backup',
                        'icono' => 'bi bi-hdd-stack',
                        'objeto' => 'Gestión de Backup',
                    ],
                ],
            ],
 'Reportes' => [
              'icono' => 'bi bi-journal-text',
                'submenus' => [
                  
                    'Reportes Persona' => [
                        'ruta' => '/reportesP',
                        'icono' => 'bi bi-journal-text',
                        'objeto' => 'Reportes',
                    ],
                    'Reportes Facturacion ' => [
                        'ruta' => '/reportesF',
                        'icono' => 'bi bi-journal-text',
                        'objeto' => 'Reportes',
                    ],
                    'Reportes Eventos' => [
                        'ruta' => '/reportesE',
                        'icono' => 'bi bi-journal-text',
                        'objeto' => 'Reportes',
                    ],
                    'Reportes Inventario' => [
                        'ruta' => '/reportesI',
                        'icono' => 'bi bi-journal-text',
                        'objeto' => 'Reportes',
                    ],
                ],
            ],
          
        ];

        // Filtrado por permisos
        $filtrado = [];
        foreach ($items as $titulo => $datos) {
            if (isset($datos['submenus'])) {
                $subfil = [];
                foreach ($datos['submenus'] as $subtitulo => $info) {
                    $obj = $info['objeto'] ?? $subtitulo;
                    if (tienePermiso($obj)) {
                        $subfil[$subtitulo] = $info;
                    }
                }
                if ($subfil) {
                    $filtrado[$titulo] = [
                        'icono' => $datos['icono'],
                        'submenus' => $subfil,
                    ];
                }
            } else {
                $obj = $datos['objeto'] ?? $titulo;
                if (tienePermiso($obj)) {
                    $filtrado[$titulo] = $datos;
                }
            }
        }

        return $filtrado;
    }
}
