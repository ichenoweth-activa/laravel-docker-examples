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
        Schema::create('session_materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_session_id');
            $table->string('nombre_material');
            $table->string('liga')->nullable();
            $table->string('file_id')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('project_session_id')
                ->references('id')
                ->on('project_sessions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_materials');
    }
};
