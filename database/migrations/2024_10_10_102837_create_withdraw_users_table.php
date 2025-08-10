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
        Schema::create('withdraw_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile')->nullable();
            $table->date('birth')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('location')->nullable();
            $table->string('source')->nullable();
            $table->text('source_etc')->nullable();
            $table->boolean('marketing')->default(false);
            $table->datetime('marketing_updated_at')->nullable();
            $table->datetime('last_logged_in')->nullable();

            $table->string('kakao_id')->nullable();
            $table->datetime('kakao_connected')->nullable();
            $table->string('naver_id')->nullable();
            $table->datetime('naver_connected')->nullable();
            $table->string('google_id')->nullable();
            $table->datetime('google_connected')->nullable();

            $table->text('memo')->nullable();

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->string('withdraw')->nullable();
            $table->text('withdraw_memo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('withdraw_users');
    }
};
