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
        Schema::table('project_notes', function (Blueprint $table): void {
            $table->string('status', 50)->default('actie')->after('priority');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_notes', function (Blueprint $table): void {
            $table->dropIndex('project_notes_status_index');
            $table->dropColumn('status');
        });
    }
};
