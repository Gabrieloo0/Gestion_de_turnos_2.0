<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turno_id')->constrained('turnos')->cascadeOnDelete();
            $table->string('tipo_notificacion');
            $table->text('mensaje');
            $table->dateTime('fecha_envio');
            $table->string('estado_envio')->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};