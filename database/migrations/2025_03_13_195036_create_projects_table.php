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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->text('contenido')->nullable();
            $table->string('descripcion');
            $table->string('proceso_desarrollo_aprendizaje')->nullable();
            $table->string('lenguaje')->nullable();
            $table->enum('nivel', ['Primaria', 'Secundaria', 'Bachillerato'])->default('Primaria');
            $table->text('producto')->nullable();
            $table->text('subproducto')->nullable();
            $table->string('escenario')->nullable();
            $table->string('grado_escolar')->nullable();
            $table->enum('status', ['ORIGINAL','CREADO', 'IMPLEMENTANDOSE', 'IMPLEMENTADO_CLASSROOM','LISTO'])
                ->default('ORIGINAL');
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->boolean('materiales_listos')->default(false);

            $table->uuid('implementado_por_user_id')->nullable();
            $table->foreign('implementado_por_user_id')
                ->references('id')
                ->on('users');

            $table->string('file_id', 900)->nullable();
            $table->string('file_name', 500)->nullable();
            $table->string('url_location_file', 1900)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
