<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horario_disponibles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peluquero_id')->constrained();
            $table->tinyInteger('dia_semana'); // 1-7 (lunes-domingo)
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('horario_disponibles');
    }
};
