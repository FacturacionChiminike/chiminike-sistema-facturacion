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
                ],
            ],
            'Gestión de Cotizaciones' => [
                'icono' => 'bi bi-journal-text',
                'submenus' => [
                    'Eventos' => [
                        'ruta' => '/cotizaciones',
                        'icono' => 'bi bi-calendar-event',
                        'objeto' => 'Gestión de cotizaciones',
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
                ],
            ],
            'Gestión de Backup' => [
                'icono' => 'bi bi-hdd-stack',
                'ruta' => '/backup',
                'objeto' => 'Gestión de Backup',
            ],
            'Bitácora del sistema' => [
                'icono' => 'bi bi-journal-text',
                'ruta' => '/bitacora',
                'objeto' => 'Bitácora del sistema',
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

