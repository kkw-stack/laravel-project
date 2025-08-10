<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('main_visuals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->string('title');
            $table->string('thumbnail');
            $table->string('thumbnail_mobile')->nullable();
            $table->text('video')->nullable();
            $table->text('video_mobile')->nullable();
            $table->string('weather_icon');
            $table->string('description')->nullable();
            $table->unsignedInteger('order_idx')->default(0);
            $table->boolean('status')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('main_visuals');
    }
};
