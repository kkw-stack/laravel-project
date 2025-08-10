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
        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->string('title');
            $table->string('image');
            $table->boolean('use_always')->default(false);
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->text('url')->nullable();
            $table->boolean('target')->default(false);
            $table->unsignedInteger('top')->nullable();
            $table->unsignedInteger('left')->nullable();
            $table->boolean('status')->default(false);
            $table->unsignedBigInteger('order_idx')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('popups');
    }
};
