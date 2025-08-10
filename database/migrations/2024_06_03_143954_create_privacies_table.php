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
        Schema::create('privacies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->string('title');
            $table->longText('content');
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
        Schema::dropIfExists('privacies');
    }
};
