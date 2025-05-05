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
            Schema::create('ready_card_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ready_card_id')->constrained()->onDelete('cascade');
                $table->string('identity_number', 4);
                $table->string('qr_code');
                $table->integer('sequence_number');
                $table->enum('status', ['open', 'closed'])->default('closed');
                $table->timestamps();
                
                // Add index for faster lookups
                $table->index(['ready_card_id', 'identity_number']);
                $table->index(['ready_card_id', 'sequence_number']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ready_card_items');
    }
};
