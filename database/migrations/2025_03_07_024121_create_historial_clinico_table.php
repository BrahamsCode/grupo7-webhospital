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
        Schema::create('historial_clinico', function (Blueprint $table) {
            $table->id('id_historial');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_consulta')->nullable();
            $table->unsignedBigInteger('id_tratamiento')->nullable();
            $table->text('notas')->nullable();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
            $table->foreign('id_consulta')->references('id_consulta')->on('consultas')->onDelete('set null');
            $table->foreign('id_tratamiento')->references('id_tratamiento')->on('tratamientos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_clinico');
    }
};
