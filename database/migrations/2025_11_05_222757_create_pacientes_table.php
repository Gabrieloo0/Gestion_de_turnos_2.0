<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->string('apellido', 80);
            $table->string('dni', 20)->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('domicilio', 160)->nullable();
            $table->string('obra_social', 120)->nullable();
            $table->string('nro_afiliado', 80)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['apellido','nombre']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('pacientes');
    }
};
