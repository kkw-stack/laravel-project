<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->json('title');
            $table->json('sector');
            $table->json('price');
            $table->json('time_table')->nullable();
            $table->boolean('use_night_time_table')->default(false);
            $table->string('night_start_date')->nullable();
            $table->string('night_end_date')->nullable();
            $table->json('night_time_table')->nullable();
            $table->json('disable_time_table')->nullable();
            $table->unsignedBigInteger('order_idx')->default(0);
            $table->boolean('status')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ticket_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('max_date')->default(30);
            $table->unsignedTinyInteger('max_count')->default(5);
            $table->unsignedTinyInteger('max_docent')->default(10);
            $table->string('summer_start')->nullable();
            $table->string('summer_end')->nullable();
            $table->string('winter_start')->nullable();
            $table->string('winter_end')->nullable();
            $table->json('closed_weekday')->nullable();
            $table->json('closed_dates')->nullable();
            $table->timestamps();
        });

        DB::table('ticket_configs')->insert([
            'max_date' => 30,
            'max_count' => 5,
            'max_docent' => 10,
            'summer_start' => null,
            'summer_end' => null,
            'winter_start' => null,
            'winter_end' => null,
            'closed_weekday' => null,
            'closed_dates' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_configs');
    }
};
