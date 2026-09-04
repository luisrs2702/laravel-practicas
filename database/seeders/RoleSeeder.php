<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $roleAdmin=Role::create(['name' => 'admin']);
       // $roleAdmin=Role::create(['name' => 'admin','guard_name' => 'api']);
        $role2=Role::create(['name' => 'recepcionista']);
        $permission = Permission::create(['name' => 'registrar visita'])->assignRole($role2);
    }
}
