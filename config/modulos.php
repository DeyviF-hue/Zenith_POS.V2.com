<?php

/*
|--------------------------------------------------------------------------
| Zenith POS - Configuración de Módulos
|--------------------------------------------------------------------------
| Aquí puedes habilitar o deshabilitar los módulos del sistema.
| Los módulos deshabilitados no aparecerán en el menú lateral.
|
*/

return [

    'clientes' => [
        'habilitado' => false,
        'nombre'     => 'Clientes',
        'icono'      => 'fas fa-users',
        'descripcion'=> 'Gestión de clientes y contactos',
    ],

    'productos' => [
        'habilitado' => true,
        'nombre'     => 'Productos',
        'icono'      => 'fas fa-box',
        'descripcion'=> 'Catálogo de productos e inventario',
    ],

    'ventas' => [
        'habilitado' => true,
        'nombre'     => 'Ventas',
        'icono'      => 'fas fa-shopping-cart',
        'descripcion'=> 'Gestión de ventas y facturación',
    ],

    'empleados' => [
        'habilitado' => false,
        'nombre'     => 'Empleados',
        'icono'      => 'fas fa-user-tie',
        'descripcion'=> 'Gestión de empleados y asesores',
    ],

    'proveedores' => [
        'habilitado' => false,
        'nombre'     => 'Proveedores',
        'icono'      => 'fas fa-truck',
        'descripcion'=> 'Gestión de proveedores',
    ],

];
