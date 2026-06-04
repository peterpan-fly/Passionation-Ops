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
        Schema::create('review_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_application_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('owner')->nullable();
            $table->string('priority')->default('medium')->index();
            $table->string('status')->default('open')->index();
            $table->date('due_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_tasks');
    }
};
