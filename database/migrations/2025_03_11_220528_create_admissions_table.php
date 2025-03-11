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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('restrict');
            $table->dateTime('admission_date');
            $table->dateTime('discharge_date')->nullable();
            $table->text('reason')->nullable();
            $table->tinyInteger('status')->default(1); // 1: active, 2: discharged, 9: cancelled
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
