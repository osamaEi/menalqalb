<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('locker_items', function (Blueprint $table) {
            $table->enum('status', ['open', 'closed', 'canceled'])
                  ->default('open')
                  ->after('number_locker');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locker_items', function (Blueprint $table) {
            //
        });
    }
};
