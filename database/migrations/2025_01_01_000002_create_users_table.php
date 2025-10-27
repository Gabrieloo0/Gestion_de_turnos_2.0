<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // 🔹 Datos personales (lo que en tu diagrama era "persona")
            $table->string('name');                  // nombre
            $table->string('last_name');             // apellido
            $table->string('email')->unique();
            $table->string('phone')->nullable();     // teléfono
            $table->date('birthdate')->nullable();   // fecha de nacimiento

            // 🔹 Autenticación (lo que en tu diagrama era "usuario")
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // 🔹 Relación con tipo_persona (FK)
            $table->foreignId('tipo_persona_id')
                ->nullable()
                ->constrained('tipo_persona')
                ->nullOnDelete();

            $table->timestamps();

            // 🔹 Índices útiles (opcional)
            $table->index(['last_name', 'name']);
            $table->index('tipo_persona_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
