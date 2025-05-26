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
        // database/migrations/[timestamp]_create_locker_items_table.php
Schema::create('locker_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('locker_id')->constrained()->onDelete('cascade');
    $table->integer('number_locker');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locker_items');
    }
};
