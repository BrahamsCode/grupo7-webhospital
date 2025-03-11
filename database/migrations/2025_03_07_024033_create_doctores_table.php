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
        Schema::create('doctores', function (Blueprint $table) {
            $table->id('id_doctor');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->string('nombre', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50)->nullable();
            $table->unsignedBigInteger('id_especialidad');
            $table->string('telefono', 15)->nullable();
            $table->string('correo', 100)->unique();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_especialidad')->references('id_especialidad')->on('especialidades'); // 🔹 Corrección aquí
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctores');
    }
};
