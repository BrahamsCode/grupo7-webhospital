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
        Schema::create('detalles_receta', function (Blueprint $table) {
            $table->id('id_detalle_receta');
            $table->unsignedBigInteger('id_receta');
            $table->unsignedBigInteger('id_medicamento');
            $table->integer('cantidad');
            $table->string('dosis', 100)->nullable();
            $table->string('frecuencia', 100)->nullable();
            $table->string('duracion', 50)->nullable();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_receta')->references('id_receta')->on('recetas_medicas');
            $table->foreign('id_medicamento')->references('id_medicamento')->on('medicamentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_receta');
    }
};
