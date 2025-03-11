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
        Schema::create('detalles_factura', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedBigInteger('id_factura');
            $table->string('concepto');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->char('tipo', 1); // C: Consulta, T: Tratamiento, M: Medicamento, H: Habitación
            $table->unsignedBigInteger('id_referencia')->nullable(); // ID de consulta, tratamiento, medicamento, etc.
            $table->char('estado_auditoria', 1)->default('A');
            $table->timestamp('fecha_creacion_auditoria')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_factura')->references('id_factura')->on('facturas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_factura');
    }
};
