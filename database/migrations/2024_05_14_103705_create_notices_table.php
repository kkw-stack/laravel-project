<?php

use App\Models\Manager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('board_notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->boolean('is_notice')->default(false);
            $table->string('title');
            $table->longText('content');
            $table->boolean('status')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('board_notices');
    }
};
