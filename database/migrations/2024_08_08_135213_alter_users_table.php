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
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile')->after('password')->nullable();
            $table->date('birth')->after('mobile')->nullable();
            $table->boolean('gender')->after('birth')->nullable();
            $table->string('location')->after('gender')->nullable();
            $table->string('source')->after('location')->nullable();
            $table->text('source_etc')->after('source')->nullable();
            $table->boolean('marketing')->default(false)->after('source_etc');
            $table->datetime('marketing_updated_at')->after('marketing')->nullable();
            $table->datetime('last_logged_in')->after('marketing_updated_at')->nullable();

            $table->string('kakao_id')->after('last_logged_in')->nullable();
            $table->datetime('kakao_connected')->after('kakao_id')->nullable();
            $table->string('naver_id')->after('kakao_connected')->nullable();
            $table->datetime('naver_connected')->after('naver_id')->nullable();
            $table->string('google_id')->after('naver_connected')->nullable();
            $table->datetime('google_connected')->after('google_id')->nullable();

            $table->text('memo')->after('google_connected')->nullable();

            $table->softDeletes();
            $table->string('withdraw')->after('deleted_at')->nullable();
            $table->text('withdraw_memo')->after('withdraw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mobile');
            $table->dropColumn('birth');
            $table->dropColumn('gender');
            $table->dropColumn('location');
            $table->dropColumn('source');
            $table->dropColumn('source_etc');
            $table->dropColumn('marketing');
            $table->dropColumn('marketing_updated_at');
            $table->dropColumn('last_logged_in');

            $table->dropColumn('kakao_id');
            $table->dropColumn('kakao_connected');
            $table->dropColumn('naver_id');
            $table->dropColumn('naver_connected');
            $table->dropColumn('google_id');
            $table->dropColumn('google_connected');

            $table->dropColumn('memo');
            $table->dropColumn('deleted_at');
            $table->dropColumn('withdraw');
            $table->dropColumn('withdraw_memo');
        });
    }
};
