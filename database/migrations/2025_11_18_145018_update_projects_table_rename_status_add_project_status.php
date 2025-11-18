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
        Schema::table('projects', function (Blueprint $table) {
            // Hernoem het huidige status veld naar build_status
            $table->renameColumn('status', 'build_status');
        });

        Schema::table('projects', function (Blueprint $table) {
            // Voeg nieuw project_status veld toe
            $table->string('project_status')->default('ingepland')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('project_status');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('build_status', 'status');
        });
    }
};
