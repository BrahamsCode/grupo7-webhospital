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
        Schema::create('seguros_medicos', function (Blueprint $table) {
            $table->id('id_seguro');
            $table->string('nombre', 100);
            $table->string('tipo_plan', 50)->nullable();
            $table->decimal('porcentaje_cobertura', 5, 2)->nullable();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguros_medicos');
    }
};
