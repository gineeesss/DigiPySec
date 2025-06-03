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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['credit_card', 'paypal', 'bank_transfer', 'cash']);
            $table->string('alias')->nullable(); // "Mi tarjeta principal", etc.
            $table->string('card_number')->nullable();
            $table->string('card_holder')->nullable();
            $table->string('expiry_month')->nullable();
            $table->string('expiry_year')->nullable();
            $table->string('last_four')->nullable(); // Últimos 4 dígitos para mostrar
            $table->string('bank_name')->nullable(); // Para transferencias
            $table->string('account_number')->nullable(); // Para transferencias
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
