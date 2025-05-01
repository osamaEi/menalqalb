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
        Schema::create('ready_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('card_count');
            $table->unsignedBigInteger('customer_id');  // User who ordered the cards
            $table->string('received_card_image')->nullable();
            $table->decimal('cost', 10, 2);
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('ready_card_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ready_card_id');
            $table->unsignedBigInteger('card_id');
            $table->timestamps();
            
            $table->foreign('ready_card_id')->references('id')->on('ready_cards')->onDelete('cascade');
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ready_cards');
    }
};
