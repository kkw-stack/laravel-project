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
        Schema::create('people_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->string('title');
            $table->string('content')->nullable();
            $table->unsignedBigInteger('order_idx')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('intro');
            $table->string('thumbnail');
            $table->boolean('use_video')->default(false);
            $table->string('image')->nullable();
            $table->tinyText('video')->nullable();
            $table->longText('content');
            $table->string('masterpiece')->nullable();
            $table->json('project')->nullable();
            $table->boolean('status')->default(false);
            $table->datetime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('people_categories');
        Schema::dropIfExists('people');
    }
};
