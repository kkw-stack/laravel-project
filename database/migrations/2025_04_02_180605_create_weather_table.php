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
        Schema::create('weather', function (Blueprint $table) {
            $table->id();
            $table->string('location')->nullable(); // 지역 (고유 값)
            $table->float('temperature')->nullable(); // 기온
            $table->string('sky', 50)->nullable(); // 하늘 상태
            $table->string('rain_type', 50)->nullable(); // 강수 유형
            $table->string('weather_type', 50)->nullable(); // 종합적인 날씨 상태
        
            // 미세먼지 관련 컬럼
            $table->unsignedInteger('pm10')->nullable(); // 미세먼지 (PM10)
            $table->unsignedInteger('pm25')->nullable(); // 초미세먼지 (PM2.5)
            $table->string('air_quality', 50)->nullable(); // 대기 질 등급
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};
