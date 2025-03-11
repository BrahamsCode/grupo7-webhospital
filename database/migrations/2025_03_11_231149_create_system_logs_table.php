<?php

// database/migrations/2024_03_11_000022_create_system_logs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action', 50);
            $table->string('module', 50);
            $table->string('reference_table')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->text('description')->nullable();
            $table->text('user_agent')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            // Índices rendimiento  búsqueda
            $table->index(['action', 'module']);
            $table->index(['reference_table', 'reference_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
