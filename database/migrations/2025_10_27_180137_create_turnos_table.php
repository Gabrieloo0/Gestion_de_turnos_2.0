<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('profesional_id')->constrained('profesionales')->cascadeOnDelete();
            $table->foreignId('servicio_id')->constrained('servicios')->cascadeOnDelete();
            $table->foreignId('consultorio_id')->nullable()->constrained('consultorios')->nullOnDelete();
            $table->date('fecha_turno');
            $table->time('hora_inicio_turno');
            $table->time('hora_fin_turno');
            $table->enum('estado_turno', ['Pendiente', 'Confirmado', 'Realizado', 'Cancelado', 'Ausente'])->default('Pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};