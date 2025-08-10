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
        Schema::create('attractions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->string('title');
            $table->text('content');
            $table->text('source')->nullable();
            $table->unsignedInteger('distance');
            $table->string('thumbnail');
            $table->boolean('status')->default(false);
            $table->datetime('published_at')->nullable();
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
        Schema::dropIfExists('attractions');
    }
};
