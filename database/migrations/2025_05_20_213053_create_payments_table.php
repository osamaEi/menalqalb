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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_intent_id')->unique();
            $table->string('order_id');
            $table->integer('amount');
            $table->string('currency', 3)->default('AED');
            $table->string('status');
            $table->text('redirect_url')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            // Optional: Add index for faster lookups
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
