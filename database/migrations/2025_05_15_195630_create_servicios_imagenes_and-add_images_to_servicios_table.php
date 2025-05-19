<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('servicio_imagenes')) {
            Schema::create('servicio_imagenes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('servicio_id')->constrained()->onDelete('cascade');
                $table->string('imagen_path');
                $table->integer('orden')->default(0);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('servicios') && !Schema::hasColumn('servicios', 'imagen_principal')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->string('imagen_principal')->nullable()->after('activo');
            });
        }
    }

    public function down()
    {
        // Primero eliminar la columna si existe
        if (Schema::hasTable('servicios') && Schema::hasColumn('servicios', 'imagen_principal')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->dropColumn('imagen_principal');
            });
        }

        // Luego eliminar la tabla si existe
        Schema::dropIfExists('servicio_imagenes');
    }
};
