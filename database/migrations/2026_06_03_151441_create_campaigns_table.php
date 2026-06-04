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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->string('name')->index();
            $table->string('campaign_type')->index();
            $table->string('status')->default('draft')->index();
            $table->json('target_niches')->nullable();
            $table->json('target_countries')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(10);
            $table->decimal('flat_fee_budget', 10, 2)->default(0);
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->text('brief')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
