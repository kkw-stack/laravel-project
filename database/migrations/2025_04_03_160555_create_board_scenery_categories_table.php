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
        Schema::create('board_scenery_categories', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('ko');
            $table->unsignedBigInteger('manager_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->bigInteger('order_idx')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_scenery_categories');
    }
};
