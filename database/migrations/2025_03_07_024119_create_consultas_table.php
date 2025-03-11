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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id('id_consulta');
            $table->unsignedBigInteger('id_cita');
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('observaciones')->nullable();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();

            $table->foreign('id_cita')->references('id_cita')->on('citas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
