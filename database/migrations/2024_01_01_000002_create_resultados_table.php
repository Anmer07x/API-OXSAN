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
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id')->nullable(); // Nullable in case result arrives before patient registration
            $table->string('numero_documento', 50)->index(); // Redundant but requested for indexing/lookup
            $table->string('codigo_orden', 50)->index();
            $table->string('examen');
            $table->text('resultado'); // Text to accommodate various formats
            $table->string('unidad', 50)->nullable();
            $table->text('valores_referencia')->nullable();
            $table->dateTime('fecha_examen');
            $table->dateTime('fecha_validacion')->nullable()->index(); // L_FECHA_VAL
            $table->boolean('exportado')->default(false);
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
