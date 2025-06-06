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
        Schema::create('pedidos_tienda', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // Ej: PED-XXXXXX
            $table->string('cliente_nombre');
            $table->string('cliente_email');
            $table->string('cliente_telefono');
            $table->text('notas')->nullable();
            $table->string('estado')->default('pendiente'); // pendiente, completado, cancelado
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_tienda');
    }
};
