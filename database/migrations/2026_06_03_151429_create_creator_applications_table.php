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
        Schema::create('creator_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->index();
            $table->string('country_region')->index();
            $table->string('discovery_source')->nullable();
            $table->string('primary_platform')->index();
            $table->string('follower_range')->index();
            $table->string('engagement_rate')->nullable()->index();
            $table->json('content_niches');
            $table->text('content_style');
            $table->string('collaboration_experience')->index();
            $table->text('past_brand_collaborations')->nullable();
            $table->string('best_branded_content_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->json('partnership_preferences');
            $table->string('commission_payout_preference')->index();
            $table->string('minimum_paid_post_rate')->nullable();
            $table->string('exclusive_partnership_preference')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('age_confirmed')->default(false);
            $table->string('status')->default('new')->index();
            $table->unsignedTinyInteger('fit_score')->default(70);
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_applications');
    }
};
