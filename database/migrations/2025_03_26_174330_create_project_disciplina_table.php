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
            Schema::create('project_disciplina', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('project_id');
                $table->uuid('disciplina_id');
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('project_id')->references('id')->on('projects');
                $table->foreign('disciplina_id')->references('id')->on('disciplinas');

                $table->unique(['project_id', 'disciplina_id']);

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_disciplina');
    }
};
