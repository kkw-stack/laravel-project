<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private $tables = [
        'users',
        'withdraw_users',
        'board_notices',
        'board_news',
        'board_events',
        'faqs',
        'faq_categories',
        'privacies',
        'services',
        'main_visuals',
        'main_feeds',
        'popups',
        'attractions',
        'korea_gardens',
        'korea_garden_categories',
        'korea_garden_feeds',
        'people',
        'people_categories',
        'histories',
        'history_categories',
        'visitor_guides',
    ];

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('locale')->after('id')->default('ko');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('locale');
            });
        }
    }
};
