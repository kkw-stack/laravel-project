<?php

use App\Models\FaqCategory;
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
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->bigInteger('order_idx')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->string('question');
            $table->text('answer');
            $table->unsignedBigInteger('faq_category_id');
            $table->boolean('status')->default(false);
            $table->datetime('published_at');
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('faq_categories');
        Schema::dropIfExists('faqs');
    }
};
