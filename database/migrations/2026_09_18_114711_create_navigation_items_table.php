<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Nombre visual (ej. "Usuarios")
            $table->string('path');          // Ruta en el frontend (ej. "/admin/users")
            $table->string('icon')->nullable(); // Icono (ej. "users-icon")
            $table->unsignedBigInteger('parent_id')->nullable(); // Para subrutas
            $table->string('permission_name'); // Permiso requerido de Spatie (ej. "manage-users")
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('navigation_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navigation_items');
    }
}
