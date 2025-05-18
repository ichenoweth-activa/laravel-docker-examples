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
        Schema::create('project_eje_articulador', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->uuid('eje_articulador_id');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['project_id', 'eje_articulador_id'], 'project_eje_articulador_unique');

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('eje_articulador_id')->references('id')->on('ejes_articuladores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_eje_articuladors');
    }
};
