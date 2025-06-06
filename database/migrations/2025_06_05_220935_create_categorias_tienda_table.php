<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias_tienda', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique(); // Para URLs amigables
            $table->string('icono')->nullable(); // Ícono para el menú
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias_tienda');
    }
};
