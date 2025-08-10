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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_mobile')->nullable();
            $table->string('user_email')->nullable();
            $table->date('user_birth')->nullable();
            $table->string('user_gender', 2)->nullable();
            $table->string('locale')->nullable();
            $table->string('code');
            $table->date('select_date');
            $table->time('select_time');
            $table->boolean('use_docent')->default(false);
            $table->json('visitors');
            $table->unsignedTinyInteger('total_visitors');
            $table->unsignedBigInteger('amount');
            $table->text('memo')->nullable();
            $table->datetime('used_at')->nullable();
            $table->datetime('canceled_at')->nullable();
            $table->unsignedBigInteger('canceled_amount')->nullable();
            $table->unsignedBigInteger('canceled_by')->nullable();
            $table->string('paid_id')->nullable();
            $table->string('paid_method')->nullable();
            $table->datetime('paid_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('reservations');
    }
};
