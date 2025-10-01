<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('description')->nullable()->change();
        });

        DB::table('projects')->whereNull('created_at')->update([
            'created_at' => now(),
        ]);

        Schema::table('projects', function (Blueprint $table) {
            $table->timestampTz('created_at')->useCurrent()->nullable(false)->change();
            $table->text('city')->nullable();
            $table->text('street')->nullable();
            $table->text('house_number')->nullable();
            $table->text('permit')->nullable();
            $table->text('status')->nullable()->default('concept');
            $table->text('current_term')->nullable();
            $table->date('start_build_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->foreignId('demolition_contractor_id')->nullable();
            $table->foreignId('build_contractor_id')->nullable();

            $table->foreign('demolition_contractor_id')->references('id')->on('contractors');
            $table->foreign('build_contractor_id')->references('id')->on('contractors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['demolition_contractor_id']);
            $table->dropForeign(['build_contractor_id']);

            $table->dropColumn([
                'city',
                'street',
                'house_number',
                'permit',
                'status',
                'current_term',
                'start_build_date',
                'completion_date',
                'demolition_contractor_id',
                'build_contractor_id',
            ]);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->change();
            $table->string('title')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
        });
    }
};
