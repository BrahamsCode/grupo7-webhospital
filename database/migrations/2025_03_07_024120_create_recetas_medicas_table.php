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
        Schema::create('recetas_medicas', function (Blueprint $table) {
            $table->id('id_receta');
            $table->unsignedBigInteger('id_consulta');
            $table->date('fecha_emision');
            $table->char('estado', 1)->default('A'); // A: Activa, C: Caducada
            $table->text('instrucciones')->nullable();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();

            $table->foreign('id_consulta')->references('id_consulta')->on('consultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas_medicas');
    }
};
