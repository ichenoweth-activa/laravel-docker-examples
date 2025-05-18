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
        Schema::create('project_area_conocimiento', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->uuid('area_conocimiento_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')->on('projects');

            $table->foreign('area_conocimiento_id')
                ->references('id')->on('area_conocimientos');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('project_area_conocimiento');
    }
};
