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
            if (Schema::hasColumn('project_notes', 'priority')) {
                $table->dropIndex('project_notes_priority_index');
                $table->dropColumn('priority');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_notes', function (Blueprint $table): void {
            $table->string('priority', 20)->default('medium');
            $table->index('priority');
        });
    }
};
