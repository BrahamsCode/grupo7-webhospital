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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id('id_paciente');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->string('nombre', 50);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100)->nullable();
            $table->char('tipo_documento', 1);
            $table->string('numero_documento', 15);
            $table->string('correo')->nullable();
            $table->string('direccion')->nullable();
            $table->char('genero', 1)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->unsignedBigInteger('id_seguro')->nullable();
            $table->string('numero_seguro', 50)->nullable();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_seguro')->references('id_seguro')->on('seguros_medicos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
