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
        Schema::create('project_unidad_aprendizaje', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->uuid('unidad_aprendizaje_id');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(
                ['project_id', 'unidad_aprendizaje_id'],
                'project_unidad_aprendizaje_unique'
            );

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('unidad_aprendizaje_id')->references('id')->on('unidad_aprendizaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_unidad_aprendizaje');
    }
};

