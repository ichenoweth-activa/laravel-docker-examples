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
        Schema::create('project_campo_formativo', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->uuid('campo_formativo_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('campo_formativo_id')->references('id')->on('campo_formativos');

            $table->unique(['project_id', 'campo_formativo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_campo_formativo');
    }
};
