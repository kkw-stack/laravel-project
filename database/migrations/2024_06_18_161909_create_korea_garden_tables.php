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
        Schema::create('korea_garden_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->string('title');
            $table->text('content');
            $table->unsignedBigInteger('order_idx')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('korea_gardens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->text('content');
            $table->string('image');
            $table->string('image_mobile')->nullable();
            $table->text('video')->nullable();
            $table->text('video_mobile')->nullable();
            $table->boolean('status')->default(false);
            $table->datetime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('korea_garden_feeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('first_post_id')->nullable();
            $table->unsignedBigInteger('second_post_id')->nullable();
            $table->unsignedBigInteger('third_post_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('korea_garden_categories');
        Schema::dropIfExists('korea_gardens');
        Schema::dropIfExists('korea_garden_feeds');
    }
};
