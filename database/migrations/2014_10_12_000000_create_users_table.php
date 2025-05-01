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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('country_id')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('email_verified')->default(false);
            $table->boolean('whatsapp_verified')->default(false);
            $table->enum('user_type', ['admin', 'privileged_user', 'regular_user', 'designer', 'sales_point'])->default('regular_user');
            $table->enum('status', ['active', 'inactive', 'blocked', 'deleted'])->default('inactive');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
