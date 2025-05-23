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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->string('type'); // package, lock, or ready_card
            $table->unsignedBigInteger('entity_id')->nullable(); // ID of package or locker
            $table->string('entity_name'); // Name of the package or locker
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->integer('quantity')->default(1);
            $table->string('status')->default('generated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
