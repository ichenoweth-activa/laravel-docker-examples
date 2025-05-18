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
        Schema::table('project_sessions', function (Blueprint $table) {
            $table->text('instrucciones_docente')->nullable()->after('sesion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_sessions', function (Blueprint $table) {
            $table->dropColumn('instrucciones_docente');
        });
    }
};
