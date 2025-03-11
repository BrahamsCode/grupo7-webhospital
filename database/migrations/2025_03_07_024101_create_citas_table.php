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
        Schema::create('citas', function (Blueprint $table) {
            $table->id('id_cita');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_doctor');
            $table->dateTime('fecha_cita');
            $table->char('estado', 1)->default('P'); // P: Programada, A: Atendida, C: Cancelada
            $table->text('notas')->nullable();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
            $table->foreign('id_doctor')->references('id_doctor')->on('doctores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
