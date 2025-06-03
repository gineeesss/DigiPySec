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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['shipping', 'billing', 'both'])->default('both');
            $table->string('contact_name'); // Nombre de contacto para envíos
            $table->string('contact_phone')->nullable(); // Teléfono de contacto
            $table->string('street');
            $table->string('street2')->nullable(); // Segunda línea de dirección
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country')->default('España');
            $table->text('instructions')->nullable(); // Instrucciones especiales
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
