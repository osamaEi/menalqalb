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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_language');
            $table->foreignId('main_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('dedication_type_id')->constrained()->onDelete('cascade');
            $table->string('card_number');
            $table->foreignId('card_id')->constrained()->onDelete('cascade');
            $table->text('message_content');
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('recipient_name');
            $table->enum('lock_type', ['no_lock', 'lock_without_heart', 'lock_with_heart']);
            $table->string('recipient_phone');
            $table->string('unlock_code')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->boolean('manually_sent')->default(false);
            $table->string('status');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('sales_outlet_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
