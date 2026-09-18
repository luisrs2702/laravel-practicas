<?php

namespace Database\Seeders;

use App\Models\NavigationItem;
use Illuminate\Database\Seeder;

class NavigationItemSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        // 1. Ruta Principal (Padre)
        $dashboard = NavigationItem::create([
            'name' => 'Dashboard',
            'path' => '/dashboard',
            'icon' => 'home-icon',
            'permission_name' => 'view-dashboard',
            'order' => 1,
        ]);

        // 2. Ruta Principal con Subrutas
        $configuracion = NavigationItem::create([
            'name' => 'Configuración',
            'path' => '/config',
            'icon' => 'settings-icon',
            'permission_name' => 'view-settings',
            'order' => 2,
        ]);

        // Subrutas de Configuración
        NavigationItem::create([
            'name' => 'Usuarios',
            'path' => '/config/users',
            'icon' => 'users-icon',
            'parent_id' => $configuracion->id, // Apunta al padre
            'permission_name' => 'manage-users',
            'order' => 1,
        ]);

        NavigationItem::create([
            'name' => 'Roles y Permisos',
            'path' => '/config/roles',
            'icon' => 'shield-icon',
            'parent_id' => $configuracion->id, // Apunta al padre
            'permission_name' => 'manage-roles',
            'order' => 2,
        ]);
       
        NavigationItem::create([
            'name' => 'Visitas',
            'path' => '/visitas',
            'icon' => 'home-icon',
            'permission_name' => 'registrar-visita',
            'order' => 1,
        ]);
    }
    
}
