<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        /*DB::table('users')->insert([
            [
                'name' => config('services.first_user.name'),
                'email' => config('services.first_user.email'),
                'password' => config('services.first_user.password'), // Encriptar la contraseña
                //'password' => Hash::make('Th1ag0$ilva!'), // Encriptar la contraseña
            ],
            // Agrega más miembros según sea necesario
        ]);*/
        User::create([
            
                'name' => config('services.first_user.name'),
                'email' => config('services.first_user.email'),
                'password' => config('services.first_user.password'), // Encriptar la contraseña
                //'password' => Hash::make('Th1ag0$ilva!'), // Encriptar la contraseña
        ])->assignRole('admin');
    }
}
