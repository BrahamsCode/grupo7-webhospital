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
        Schema::create('horarios_doctores', function (Blueprint $table) {
            $table->id('id_horario');
            $table->unsignedBigInteger('id_doctor');
            $table->char('dia_semana', 1);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_doctor')->references('id_doctor')->on('doctores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_doctores');
    }
};
