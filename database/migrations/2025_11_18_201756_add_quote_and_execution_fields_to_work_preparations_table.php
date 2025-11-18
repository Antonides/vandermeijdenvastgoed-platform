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
        Schema::table('work_preparations', function (Blueprint $table) {
            // Offerte velden
            $table->date('quote_request_date')->nullable()->after('received_date');
            $table->date('quote_received_date')->nullable()->after('quote_request_date');
            $table->date('quote_approved_date')->nullable()->after('quote_received_date');

            // Uitvoering velden
            $table->date('execution_date')->nullable()->after('quote_approved_date');
            $table->date('execution_received_date')->nullable()->after('execution_date');

            // Indexes voor snellere queries/sorting
            $table->index('quote_request_date');
            $table->index('quote_received_date');
            $table->index('quote_approved_date');
            $table->index('execution_date');
            $table->index('execution_received_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_preparations', function (Blueprint $table) {
            // Drop indexes eerst
            $table->dropIndex(['quote_request_date']);
            $table->dropIndex(['quote_received_date']);
            $table->dropIndex(['quote_approved_date']);
            $table->dropIndex(['execution_date']);
            $table->dropIndex(['execution_received_date']);

            // Drop columns
            $table->dropColumn([
                'quote_request_date',
                'quote_received_date',
                'quote_approved_date',
                'execution_date',
                'execution_received_date',
            ]);
        });
    }
};
