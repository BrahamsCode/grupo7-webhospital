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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('id_factura');
            $table->unsignedBigInteger('id_paciente');
            $table->date('fecha_emision');
            $table->decimal('monto_total', 10, 2);
            $table->decimal('monto_seguro', 10, 2)->default(0);
            $table->decimal('monto_final', 10, 2);
            $table->char('estado', 1)->default('P'); // P: Pendiente, A: Abonada, C: Cancelada
            $table->text('notas')->nullable();
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
