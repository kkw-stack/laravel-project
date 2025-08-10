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
        Schema::create('main_sceneries', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('ko');
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('first_post_id')->nullable();
            $table->unsignedBigInteger('second_post_id')->nullable();
            $table->unsignedBigInteger('third_post_id')->nullable();
            $table->unsignedBigInteger('four_post_id')->nullable();
            $table->unsignedBigInteger('five_post_id')->nullable();
            $table->unsignedBigInteger('six_post_id')->nullable();
            $table->unsignedBigInteger('seven_post_id')->nullable();
            $table->unsignedBigInteger('eight_post_id')->nullable();
            $table->unsignedBigInteger('nine_post_id')->nullable();
            $table->unsignedBigInteger('ten_post_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_sceneries');
    }
};
