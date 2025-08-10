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
        Schema::create('board_sceneries', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('ko');
            $table->unsignedBigInteger('manager_id');
            $table->string('title');
            $table->unsignedBigInteger('scenery_category_id');
            $table->string('thumbnail');
            $table->boolean('status')->default(false);
            $table->datetime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_sceneries');
    }
};
