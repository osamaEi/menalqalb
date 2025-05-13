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
        Schema::create('locks_w_ready_cards', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('points')->default(0);
            $table->enum('type', ['lock', 'read_card']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locks_w_ready_cards');
    }
};
