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
            $table->decimal('oppervlakte_perceel', 10, 2)->nullable()->after('house_number');
            $table->decimal('oppervlakte_begane_grond', 10, 2)->nullable()->after('oppervlakte_perceel');
            $table->decimal('oppervlakte_verdieping', 10, 2)->nullable()->after('oppervlakte_begane_grond');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['oppervlakte_perceel', 'oppervlakte_begane_grond', 'oppervlakte_verdieping']);
        });
    }
};
