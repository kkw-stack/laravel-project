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
        Schema::create('board_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_id');
            $table->string('board_type');
            $table->string('file_mime');
            $table->string('file_name');
            $table->string('file_size');
            $table->string('file_path');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_files');
    }
};
