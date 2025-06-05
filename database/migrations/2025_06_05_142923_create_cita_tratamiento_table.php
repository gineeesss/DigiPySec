<?php

// database/migrations/[timestamp]_create_cita_tratamiento_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cita_tratamiento', function (Blueprint $table) {
            $table->foreignId('cita_id')->constrained()->onDelete('cascade');
            $table->foreignId('tratamiento_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->timestamps();

            $table->primary(['cita_id', 'tratamiento_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cita_tratamiento');
    }
};
