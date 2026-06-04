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
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_link_id')->constrained()->cascadeOnDelete();
            $table->string('order_reference')->unique();
            $table->decimal('order_value', 12, 2);
            $table->decimal('commission_amount', 12, 2);
            $table->string('status')->default('pending')->index();
            $table->timestamp('converted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversions');
    }
};
