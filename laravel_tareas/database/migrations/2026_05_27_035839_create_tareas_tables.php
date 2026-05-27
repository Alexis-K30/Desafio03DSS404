<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['pendiente', 'en_progreso', 'completada', 'cancelada'])
                  ->default('pendiente');
            $table->date('fecha_limite')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};