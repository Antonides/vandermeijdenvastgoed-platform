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
        Schema::create('tenders', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contractor_id')->nullable()->constrained()->nullOnDelete();
            $table->string('component', 255);
            $table->date('request_date')->nullable();
            $table->date('received_date')->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('project_id');
            $table->index('contractor_id');
            $table->index('request_date');
            $table->index('received_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
