<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contractors', function (Blueprint $table): void {
            $table->string('street')->nullable()->after('specialization');
            $table->string('house_number', 20)->nullable()->after('street');
            $table->string('postal_code', 20)->nullable()->after('house_number');
            $table->string('city')->nullable()->after('postal_code');
        });
    }

    public function down(): void
    {
        Schema::table('contractors', function (Blueprint $table): void {
            $table->dropColumn([
                'street',
                'house_number',
                'postal_code',
                'city',
            ]);
        });
    }
};
