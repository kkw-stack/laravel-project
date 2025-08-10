<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('main_feeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->enum('first_post_type', ['notice', 'news', 'event'])->nullable();
            $table->unsignedBigInteger('first_post_id')->nullable();
            $table->enum('second_post_type', ['notice', 'news', 'event'])->nullable();
            $table->unsignedBigInteger('second_post_id')->nullable();
            $table->enum('third_post_type', ['notice', 'news', 'event'])->nullable();
            $table->unsignedBigInteger('third_post_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_feeds');
    }
};
