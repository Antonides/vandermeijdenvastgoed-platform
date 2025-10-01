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
        Schema::create('work_preparations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('component', 255);
            $table->date('request_date')->nullable();
            $table->date('planned_date')->nullable();
            $table->date('received_date')->nullable();
            $table->string('party', 255)->nullable();
            $table->string('status', 50)->default('concept');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('request_date');
            $table->index('planned_date');
            $table->index('received_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_preparations');
    }
};
