<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('birthdate')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->foreignId('tipo_persona_id')
                ->nullable()
                ->constrained('tipo_persona')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['last_name', 'name']);
            $table->index('tipo_persona_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
