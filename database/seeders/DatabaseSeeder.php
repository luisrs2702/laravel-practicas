<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        $this->call([
            UserSeeder::class,
            PlanesSeeder::class,
            MiembroSeeder::class,
            RoleSeeder::class,
            // Agrega aquí cualquier otro seeder que necesites
        ]);
    }
}

//para desplegar enrailway ya no es necesario incluir la variable NIXPACKS_BUILD_CMD=composer install && npm install --production && php artisan optimize && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php artisan db:seed --force ya que con este archivo se hace todo